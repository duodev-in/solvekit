/**
 * 12-hour ↔ 24-hour (military) time. 2400 is accepted as the end of the day.
 */
const ONES = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
const TENS = ['', '', 'twenty', 'thirty', 'forty', 'fifty'];

function words(number) {
    return number < 20 ? ONES[number] : `${TENS[Math.floor(number / 10)]}${number % 10 ? `-${ONES[number % 10]}` : ''}`;
}

/**
 * Parses "1430", "14:30" or "14:30:15". Returns { hours, minutes, seconds } or null.
 */
export function parse24(text) {
    const match = String(text).trim().match(/^(\d{1,2}):?(\d{2})(?::?(\d{2}))?$/);

    if (!match) {
        return null;
    }

    const [hours, minutes, seconds = 0] = match.slice(1).map((part) => (part === undefined ? 0 : Number(part)));

    if (minutes > 59 || seconds > 59 || hours > 24 || (hours === 24 && (minutes > 0 || seconds > 0))) {
        return null;
    }

    return { hours, minutes, seconds };
}

export function to12({ hours, minutes, seconds }) {
    const period = hours % 24 < 12 ? 'AM' : 'PM';
    const hour12 = hours % 12 === 0 ? 12 : hours % 12;

    return `${hour12}:${String(minutes).padStart(2, '0')}${seconds ? `:${String(seconds).padStart(2, '0')}` : ''} ${period}`;
}

export function to24({ hours, minutes, seconds }) {
    return `${String(hours).padStart(2, '0')}${String(minutes).padStart(2, '0')}${seconds ? `:${String(seconds).padStart(2, '0')}` : ''}`;
}

export function spoken({ hours, minutes }) {
    const hourWords = hours === 0 ? 'zero' : hours < 10 ? `zero ${words(hours)}` : words(hours);
    const minuteWords = minutes === 0 ? 'hundred' : minutes < 10 ? `zero ${words(minutes)}` : words(minutes);

    return `${hourWords} ${minuteWords} hours`;
}

export default function militaryTime(ctx) {
    ctx.onUpdate(() => {
        let time;

        if (ctx.choice('mode') === 'to24') {
            const hour = ctx.number('hour12');
            const minute = ctx.number('minute12');

            if (Number.isNaN(hour) || Number.isNaN(minute)) {
                ctx.clearResult('Enter the hour and minutes.');

                return;
            }

            if (!Number.isInteger(hour) || hour < 1 || hour > 12 || !Number.isInteger(minute) || minute < 0 || minute > 59) {
                ctx.showError('Use an hour from 1 to 12 and minutes from 0 to 59.');

                return;
            }

            const pm = ctx.choice('period') === 'pm';
            time = { hours: (hour % 12) + (pm ? 12 : 0), minutes: minute, seconds: 0 };
            ctx.showResult({ value: to24(time), unit: '', label: '24-hour time', sub: spoken(time) });
        } else {
            const text = ctx.field('time24').value;

            if (text.trim() === '') {
                ctx.clearResult('Enter a 24-hour time such as 1430.');

                return;
            }

            time = parse24(text);

            if (!time) {
                ctx.showError('Use HHMM or HH:MM with hours 00 to 23 (or 2400) and minutes 00 to 59.');

                return;
            }

            ctx.showResult({ value: to12(time), unit: '', label: '12-hour time', sub: time.hours === 24 ? 'End of the day (same moment as 0000 the next day)' : spoken(time) });
        }

        ctx.setRow('t24', to24(time));
        ctx.setRow('t24colon', `${String(time.hours).padStart(2, '0')}:${String(time.minutes).padStart(2, '0')}`);
        ctx.setRow('t12', to12(time));
        ctx.setRow('spoken', spoken(time));
        ctx.setRow('since', `${time.hours * 60 + time.minutes} minutes`);
    });
}
