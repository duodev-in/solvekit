import { defineTools } from '../engines/formula.js';
import { addDays, parseDate, shortDate, toDays } from '../everyday/dates.js';
import { parseRows } from '../rows-editor.js';
import { eer } from './hl-diet.js';

/**
 * Pregnancy dating, menstrual cycles, ultrasound measurements, fertility and lactation tools, and pediatric helpers.
 * Dates arrive as 'YYYY-MM-DD', height in metres, mass in grams. Dating follows ACOG Committee Opinion 700 (2017).
 */
const ok = (...values) => values.every(Number.isFinite);
const or0 = (value) => (Number.isFinite(value) ? value : 0);
const f0 = (x) => (Number.isFinite(x) ? Math.round(x).toLocaleString('en-US') : '—');
const f1 = (x) => (Number.isFinite(x) ? x.toFixed(1) : '—');
const kgOf = (g) => g / 1000;
const OZ = 29.5735;
const plural = (n, word) => `${n} ${word}${n === 1 ? '' : 's'}`;
const weeksDays = (days) => `${plural(Math.floor(days / 7), 'week')} ${plural(days % 7, 'day')}`;
const gaText = (days) => `${Math.floor(days / 7)}+${days % 7}`;
const span = (from, to) => `${shortDate(from)} – ${shortDate(to)}`;
const cycleOf = (i) => (ok(i.cycle) && i.cycle >= 20 && i.cycle <= 45 ? Math.round(i.cycle) : 28);

/** Due date (EDD) from the chosen dating method. */
export function dueDate(i, method) {
    if (method === 'lmp') {
        const lmp = parseDate(i.lmp);

        return lmp ? { edd: addDays(lmp, 280 + cycleOf(i) - 28), basis: `First day of the last period plus 280 days${cycleOf(i) === 28 ? '' : `, adjusted ${cycleOf(i) - 28 > 0 ? '+' : ''}${cycleOf(i) - 28} days for a ${cycleOf(i)}-day cycle`} (Naegele)` } : null;
    }

    if (method === 'conception') {
        const date = parseDate(i.conception);

        return date ? { edd: addDays(date, 266), basis: 'Conception plus 266 days' } : null;
    }

    if (method === 'ivf') {
        const date = parseDate(i.transfer);
        const embryo = Number(i.embryo) || 5;

        return date ? { edd: addDays(date, 266 - embryo), basis: `Day-${embryo} embryo transfer plus ${266 - embryo} days` } : null;
    }

    if (method === 'ultrasound') {
        const date = parseDate(i.scan);
        const ga = or0(i.scan_weeks) * 7 + or0(i.scan_days);

        return date && ga > 0 ? { edd: addDays(date, 280 - ga), basis: `Ultrasound on ${shortDate(date)} at ${gaText(ga)} weeks` } : null;
    }

    const date = parseDate(i.due);

    return date ? { edd: date, basis: 'Due date as given' } : null;
}

const MILESTONES = [[0, 'First day of last period (LMP)'], [14, 'Conception (about)'], [97, 'End of first trimester (13+6)'], [126, 'Anatomy scan window opens (18 weeks)'], [168, 'Viability milestone (24 weeks)'],
    [196, 'Third trimester begins (28 weeks)'], [259, 'Early term (37 weeks)'], [273, 'Full term (39 weeks)'], [280, 'Due date (40 weeks)'], [287, 'Late term (41 weeks)'], [294, 'Post-term (42 weeks)']];

function pregnancyResult(i, c) {
    const method = c.method ?? i.method ?? 'lmp';
    const dated = dueDate(i, method);
    const today = parseDate(i.today);

    if (!dated) {
        return { empty: 'Enter the date for the chosen method.' };
    }

    const { edd } = dated;
    const lmp = addDays(edd, -280);
    const conception = addDays(edd, -266);
    const ga = today ? toDays(today) - toDays(lmp) : NaN;
    const toGo = today ? toDays(edd) - toDays(today) : NaN;
    const trimester = !Number.isFinite(ga) ? '—' : ga < 0 ? 'Before this pregnancy' : ga < 98 ? 'First trimester' : ga < 196 ? 'Second trimester' : ga <= 300 ? 'Third trimester' : 'Past 42 weeks';
    const now = !Number.isFinite(ga) ? 'Enter today\'s date' : ga < 0 ? `${f0(-ga)} days before the LMP date` : ga > 310 ? `${weeksDays(ga)} (check the dates)` : `${weeksDays(ga)} (${gaText(ga)})`;
    const rows = {
        due: shortDate(edd),
        lmp: shortDate(lmp),
        conception: `${shortDate(conception)} (fertile window ${span(addDays(conception, -5), conception)})`,
        now,
        trimester,
        left: !Number.isFinite(toGo) ? '—' : toGo >= 0 ? `${f0(toGo)} days (${weeksDays(toGo)})` : `${f0(-toGo)} days past the due date`,
        basis: dated.basis,
    };
    const grids = { milestones: { columns: ['Date', 'Weeks'], rows: MILESTONES.map(([day, text]) => ({ header: text, cells: [shortDate(addDays(lmp, day)), gaText(day)], highlight: Number.isFinite(ga) && ga >= day && (MILESTONES.find(([d]) => d > day)?.[0] ?? 999) > ga })) } };
    const focus = c.focus ?? 'due';

    if (focus === 'age') {
        if (!Number.isFinite(ga) || ga < 0) {
            return { empty: 'Enter an “as of” date after the start of the pregnancy.' };
        }

        return { value: weeksDays(ga), label: 'Gestational age', sub: `${trimester}; due ${shortDate(edd)}`, rows, grids };
    }

    if (focus === 'reverse') {
        return { value: shortDate(lmp), label: 'First day of the last period', sub: `Conception about ${shortDate(conception)}`, rows, grids };
    }

    if (focus === 'conception') {
        return { value: shortDate(conception), label: 'Likely conception date', sub: `Most likely fertile window ${span(addDays(conception, -5), conception)}`, rows, grids };
    }

    return { value: shortDate(edd), label: 'Estimated due date', sub: Number.isFinite(ga) && ga >= 0 && ga <= 310 ? `${gaText(ga)} weeks today; ${trimester.toLowerCase()}` : dated.basis, rows, grids };
}

/** ACOG Committee Opinion 700: redate to the ultrasound when it differs from LMP dating by more than these days. */
const REDATE = [[62, 5, 'up to 8+6 weeks'], [97, 7, '9+0 to 13+6 weeks'], [111, 7, '14+0 to 15+6 weeks'], [153, 10, '16+0 to 21+6 weeks'], [195, 14, '22+0 to 27+6 weeks'], [Infinity, 21, '28 weeks or later']];

/** Daily basal temperatures: the three-over-six rule (three readings above the highest of the six before). */
export function bbtShift(temps, step) {
    for (let k = 6; k + 2 < temps.length; k += 1) {
        const cover = Math.max(...temps.slice(k - 6, k));

        if (temps[k] > cover && temps[k + 1] > cover && temps[k + 2] >= cover + step) {
            return { index: k, cover };
        }
    }

    return null;
}

// Trussell, Contraception 2011: % of women with an unintended pregnancy in the first year (typical use, perfect use).
const CONTRACEPTION = {
    none: ['No method', 85, 85], spermicide: ['Spermicides', 28, 18], fam: ['Fertility awareness methods', 24, 3], withdrawal: ['Withdrawal', 22, 4], sponge: ['Sponge (never given birth)', 12, 9],
    female_condom: ['Female condom', 21, 5], condom: ['Male condom', 18, 2], diaphragm: ['Diaphragm', 12, 6], pill: ['Pill (combined or progestin-only)', 9, 0.3], patch: ['Patch', 9, 0.3], ring: ['Vaginal ring', 9, 0.3],
    injection: ['Injection (Depo-Provera)', 6, 0.2], copper: ['Copper IUD', 0.8, 0.6], lng: ['Hormonal IUD (levonorgestrel)', 0.2, 0.2], implant: ['Implant', 0.05, 0.05], tubal: ['Female sterilisation', 0.5, 0.5], vasectomy: ['Vasectomy', 0.15, 0.1],
};

// IOM 2009 gestational weight gain: total kg (low, high) and weekly kg in the 2nd and 3rd trimesters; twins (provisional) total only.
const IOM = [[0, 'Underweight (BMI under 18.5)', 12.5, 18, 0.44, 0.58, null], [18.5, 'Healthy weight (18.5–24.9)', 11.5, 16, 0.35, 0.5, [17, 25]], [25, 'Overweight (25–29.9)', 7, 11.5, 0.23, 0.33, [14, 23]], [30, 'Obesity (30 or more)', 5, 9, 0.17, 0.27, [11, 19]]];

// WHO laboratory manual for semen (6th edition, 2021): fifth-centile lower reference limits.
const WHO_SEMEN = [['volume', 'Semen volume', 1.4, 'mL'], ['concentration', 'Concentration', 16, 'million/mL'], ['total', 'Total sperm number', 39, 'million'], ['motility', 'Total motility', 42, '%'], ['progressive', 'Progressive motility', 30, '%'], ['morphology', 'Normal forms', 4, '%'], ['vitality', 'Vitality', 54, '%']];

/** Child eye colour by a simplified two-gene model: bey2 (brown dominant) and gey (green dominant over blue). */
export function eyeColour(mother, father) {
    // Genotypes as [bey2 brown alleles, gey green alleles], each 0–2, with Hardy–Weinberg priors at allele frequency 0.5.
    const prior = [0.25, 0.5, 0.25];
    const phenotype = ([b, g]) => (b > 0 ? 'brown' : g > 0 ? 'green' : 'blue');
    const genotypes = (colour) => {
        const list = [];

        for (let b = 0; b < 3; b += 1) {
            for (let g = 0; g < 3; g += 1) {
                if (phenotype([b, g]) === colour) {
                    list.push([[b, g], prior[b] * prior[g]]);
                }
            }
        }

        const total = list.reduce((sum, [, w]) => sum + w, 0);

        return list.map(([gt, w]) => [gt, w / total]);
    };
    const gamete = (count) => count / 2;
    const out = { brown: 0, green: 0, blue: 0 };

    for (const [m, wm] of genotypes(mother)) {
        for (const [f, wf] of genotypes(father)) {
            for (const bm of [0, 1]) {
                for (const bf of [0, 1]) {
                    for (const gm of [0, 1]) {
                        for (const gf of [0, 1]) {
                            const p = (bm ? gamete(m[0]) : 1 - gamete(m[0])) * (bf ? gamete(f[0]) : 1 - gamete(f[0])) * (gm ? gamete(m[1]) : 1 - gamete(m[1])) * (gf ? gamete(f[1]) : 1 - gamete(f[1]));

                            out[phenotype([bm + bf, gm + gf])] += wm * wf * p;
                        }
                    }
                }
            }
        }
    }

    return out;
}

export const handlers = {
    pregnancy: (i, c) => pregnancyResult(i, c ?? {}),

    edd_compare: (i) => {
        const lmp = parseDate(i.lmp);
        const scan = parseDate(i.scan);
        const usGa = or0(i.scan_weeks) * 7 + or0(i.scan_days);

        if (!lmp || !scan || usGa <= 0) {
            return { empty: 'Enter the last period, the scan date and the gestational age measured on the scan.' };
        }

        const byLmp = addDays(lmp, 280 + cycleOf(i) - 28);
        const byUs = addDays(scan, 280 - usGa);
        const diff = toDays(byLmp) - toDays(byUs);
        const rule = REDATE.find(([upTo]) => usGa <= upTo);
        const redate = Math.abs(diff) > rule[1];
        const final = redate ? byUs : byLmp;

        return {
            value: shortDate(final),
            label: 'Estimated date of delivery',
            sub: redate ? `Use the ultrasound date: it differs from LMP dating by ${Math.abs(diff)} days (more than ${rule[1]} at ${rule[2]})` : `Keep the LMP date: the scan agrees within ${rule[1]} days at ${rule[2]}`,
            rows: { lmp: shortDate(byLmp), us: shortDate(byUs), difference: `${Math.abs(diff)} days (${diff > 0 ? 'LMP date later' : diff < 0 ? 'LMP date earlier' : 'same'})`, rule: `Redate when the difference is over ${rule[1]} days at ${rule[2]}`, source: 'ACOG Committee Opinion 700 (2017), with AIUM and SMFM' },
        };
    },

    ovulation: (i) => {
        const lmp = parseDate(i.lmp);
        const cycle = cycleOf(i);

        if (!lmp) {
            return { empty: 'Enter the first day of your last period.' };
        }

        const cycles = Array.from({ length: 6 }, (_, n) => {
            const start = addDays(lmp, n * cycle);
            const ov = addDays(start, cycle - 14);

            return { start, ov, fertile: [addDays(ov, -5), addDays(ov, 1)] };
        });
        const first = cycles[0];

        return {
            value: shortDate(first.ov),
            label: 'Estimated ovulation',
            sub: `Fertile window ${span(...first.fertile)}; next period ${shortDate(cycles[1].start)}`,
            rows: { fertile: span(...first.fertile), peak: span(addDays(first.ov, -2), first.ov), next: shortDate(cycles[1].start), test: `Ovulation tests from ${shortDate(addDays(first.ov, -4))}`, note: 'Ovulation varies by several days even in regular cycles (Wilcox 2000)' },
            grids: { cycles: { columns: ['Fertile window', 'Ovulation', 'Period'], rows: cycles.map((x, n) => ({ header: `Cycle ${n + 1}`, cells: [span(...x.fertile), shortDate(x.ov), shortDate(x.start)] })) } },
        };
    },

    period: (i) => {
        const lmp = parseDate(i.lmp);
        const cycle = cycleOf(i);
        const length = ok(i.length) && i.length > 0 ? Math.round(i.length) : 5;

        if (!lmp) {
            return { empty: 'Enter the first day of your last period.' };
        }

        const rows = Array.from({ length: 6 }, (_, n) => {
            const start = addDays(lmp, (n + 1) * cycle);
            const ov = addDays(start, -14);

            return { header: `Period ${n + 1}`, cells: [span(start, addDays(start, length - 1)), span(addDays(ov, -5), addDays(ov, 1)), shortDate(ov)] };
        });
        const next = addDays(lmp, cycle);

        return {
            value: shortDate(next),
            label: 'Next period starts',
            sub: `Lasting to about ${shortDate(addDays(next, length - 1))}; then every ${cycle} days`,
            rows: { cycle: `${cycle} days`, fertile: rows[0].cells[1], normal: 'Cycles of 21–35 days (adults) and periods of up to 7 days are typical (ACOG)' },
            grids: { periods: { columns: ['Period', 'Fertile window before it', 'Ovulation'], rows } },
        };
    },

    implantation: (i) => {
        const lmp = parseDate(i.lmp);
        const given = parseDate(i.ovulation);
        const ov = i.know === 'ovulation' ? given : lmp ? addDays(lmp, cycleOf(i) - 14) : null;

        if (!ov) {
            return { empty: 'Enter your last period (or ovulation date).' };
        }

        return {
            value: span(addDays(ov, 8), addDays(ov, 10)),
            label: 'Most likely implantation',
            sub: `Possible from ${shortDate(addDays(ov, 6))} to ${shortDate(addDays(ov, 12))}`,
            rows: { ovulation: shortDate(ov), window: span(addDays(ov, 6), addDays(ov, 12)), test: `Sensitive tests may turn positive from about ${shortDate(addDays(ov, 11))}; most reliable from ${shortDate(addDays(ov, 14))}`, source: 'Wilcox et al., N Engl J Med 1999: 84% implanted 8–10 days after ovulation' },
        };
    },

    pregnancy_test: (i) => {
        const lmp = parseDate(i.lmp);
        const given = parseDate(i.ovulation);
        const ov = i.know === 'ovulation' ? given : lmp ? addDays(lmp, cycleOf(i) - 14) : null;

        if (!ov) {
            return { empty: 'Enter your last period (or ovulation date).' };
        }

        const missed = addDays(ov, 14);

        return {
            value: shortDate(missed),
            label: 'Test from (the day of the missed period)',
            sub: `Early sensitive tests may work from ${shortDate(addDays(ov, 10))}; a negative early test should be repeated`,
            rows: { earliest: `${shortDate(addDays(ov, 10))} (10 days after ovulation)`, missed: shortDate(missed), reliable: `${shortDate(addDays(missed, 7))} (a week after the missed period)`, ovulation: shortDate(ov), note: 'Home tests detect hCG from about 25 mIU/mL; levels double every 2–3 days in early pregnancy' },
        };
    },

    luteal: (i) => {
        if (!ok(i.cycle, i.ov_day) || i.ov_day >= i.cycle) {
            return { empty: 'Enter your cycle length and the cycle day you ovulated (day 1 = first day of the period).' };
        }

        const luteal = Math.round(i.cycle - i.ov_day);

        return { value: `${luteal} days`, label: 'Luteal phase', sub: luteal < 10 ? 'Short (under 10 days): worth discussing with a doctor if trying to conceive' : luteal > 16 ? 'Long (over 16 days): check the ovulation date, or take a pregnancy test' : 'Within the typical 11–16 days', rows: { follicular: `${Math.round(i.ov_day)} days (follicular phase, including the period)`, note: 'The luteal phase runs from ovulation to the day before the next period' } };
    },

    clomid: (i) => {
        const start = parseDate(i.start);

        if (!start) {
            return { empty: 'Enter the first day of your period (cycle day 1).' };
        }

        const first = Number(i.days) === 5 ? 5 : 3;
        const last = first + 4;
        const ov = [addDays(start, last + 4), addDays(start, last + 9)];

        return {
            value: span(...ov),
            label: 'Expected ovulation window',
            sub: `Usually 5–10 days after the last tablet (cycle day ${last}): cycle days ${last + 5}–${last + 10}`,
            rows: { tablets: `${span(addDays(start, first - 1), addDays(start, last - 1))} (days ${first}–${last})`, tests: `Ovulation tests from ${shortDate(addDays(start, last + 2))}`, intercourse: `Every 1–2 days from ${shortDate(addDays(start, last + 2))} to ${shortDate(addDays(start, last + 11))}`, note: 'Take clomiphene only as prescribed; the clinic may track ovulation by scan' },
        };
    },

    bbt: (i) => {
        const fahrenheit = i.unit === 'f';
        const readings = parseRows(i.temps).map(([day, temp]) => ({ day, temp: Number(String(temp ?? '').replace(',', '.')) })).filter((r) => Number.isFinite(r.temp));

        if (readings.length < 9) {
            return { empty: 'Enter at least 9 daily temperatures, one row per day.' };
        }

        const shift = bbtShift(readings.map((r) => r.temp), fahrenheit ? 0.2 : 0.1);
        const fmt = (t) => `${t.toFixed(fahrenheit ? 1 : 2)} °${fahrenheit ? 'F' : 'C'}`;
        const cover = shift ? shift.cover + (fahrenheit ? 0.1 : 0.05) : NaN;

        return {
            value: shift ? `Day ${readings[shift.index - 1].day}` : 'No shift yet',
            label: 'Likely ovulation (day before the rise)',
            sub: shift ? `Temperature rise confirmed from day ${readings[shift.index].day}; coverline ${fmt(cover)}` : 'Three readings above the highest of the previous six have not appeared',
            rows: { cover: shift ? fmt(cover) : '—', rise: shift ? `${readings.length - shift.index} days above the coverline so far` : 'Keep charting', note: 'BBT confirms ovulation after it happens; it cannot predict it in the same cycle' },
            grids: { temps: { columns: ['Temperature', 'Phase'], rows: readings.map((r, n) => ({ header: `Day ${r.day}`, cells: [fmt(r.temp), !shift ? '—' : n < shift.index ? 'Before the shift' : 'After the shift'], highlight: shift && n >= shift.index && n < shift.index + 3 })) } },
        };
    },

    birth_control: (i) => {
        const method = CONTRACEPTION[i.method] ?? CONTRACEPTION.condom;
        const years = ok(i.years) && i.years > 0 ? i.years : 1;
        const over = (p) => 100 * (1 - (1 - p / 100) ** years);

        return {
            value: `${method[1] < 1 ? method[1] : f0(method[1])}%`,
            label: `${method[0]}: chance of pregnancy in the first year (typical use)`,
            sub: `${method[2]}% with perfect use; over ${years} year${years === 1 ? '' : 's'} about ${f1(over(method[1]))}% (typical)`,
            rows: { perfect: `${method[2]}% in the first year`, years: `${f1(over(method[1]))}% typical, ${f1(over(method[2]))}% perfect over ${years} year${years === 1 ? '' : 's'}`, note: 'Rates are for the first year in US studies; later years are usually lower, so the multi-year figure is an upper estimate', source: 'Trussell, Contraception 2011 (Contraceptive Technology)' },
            grids: { methods: { columns: ['Typical use', 'Perfect use'], rows: Object.entries(CONTRACEPTION).map(([key, [name, typical, perfect]]) => ({ header: name, cells: [`${typical}%`, `${perfect}%`], highlight: key === i.method })) } },
        };
    },

    pearl: (i) => {
        const months = or0(i.women) * or0(i.months);

        if (!ok(i.pregnancies) || months <= 0) {
            return { empty: 'Enter pregnancies, women and months of use.' };
        }

        const index = (i.pregnancies * 1200) / months;

        return { value: index.toFixed(2), label: 'Pearl index (pregnancies per 100 woman-years)', sub: `${f0(i.pregnancies)} pregnancies in ${f0(months)} woman-months (${f1(months / 12)} woman-years)`, rows: { formula: 'PI = pregnancies × 1,200 ÷ woman-months of use', note: 'Life-table rates are preferred for comparing methods, as the Pearl index falls with longer studies' } };
    },

    crl: (i) => {
        if (!ok(i.crl) || i.crl < 2 || i.crl > 84) {
            return { empty: 'Enter a crown-rump length of 2–84 mm (about 6–14 weeks).' };
        }

        // Robinson & Fleming (1975): GA (days) = 8.052 × √CRL (mm) + 23.73.
        const days = Math.round(8.052 * Math.sqrt(i.crl) + 23.73);
        const scan = parseDate(i.scan);

        return { value: weeksDays(days), label: 'Gestational age by CRL', sub: scan ? `Due date ${shortDate(addDays(scan, 280 - days))}` : 'Add the scan date for the due date', rows: { days: `${days} days`, due: scan ? shortDate(addDays(scan, 280 - days)) : '—', accuracy: 'CRL dating before 14 weeks is accurate to about ± 5–7 days (ACOG)', source: 'Robinson & Fleming, Br J Obstet Gynaecol 1975' } };
    },

    msd: (i) => {
        if (!ok(i.d1, i.d2, i.d3) || i.d1 <= 0) {
            return { empty: 'Enter the three sac diameters in mm.' };
        }

        const msd = (i.d1 + i.d2 + i.d3) / 3;
        const days = Math.round(msd + 30);

        return { value: `${f1(msd)} mm`, label: 'Mean sac diameter', sub: `About ${weeksDays(days)} (MSD + 30 days)`, rows: { ga: `${days} days`, note: msd >= 25 ? 'An MSD of 25 mm or more with no embryo meets the criteria for a failed pregnancy (Doubilet et al. 2013); this needs review by the care team' : 'Crown-rump length replaces MSD for dating once an embryo is seen', source: 'Gestational age ≈ MSD + 30 days (Hellman 1969)' } };
    },

    hcg: (i) => {
        if (!ok(i.h1, i.h2, i.hours) || i.h1 <= 0 || i.h2 <= 0 || i.hours <= 0) {
            return { empty: 'Enter both hCG levels and the hours between them.' };
        }

        const ratio = i.h2 / i.h1;
        const rise48 = 100 * (ratio ** (48 / i.hours) - 1);
        const minimum = i.h1 < 1500 ? 49 : i.h1 < 3000 ? 40 : 33;

        if (ratio <= 1) {
            return { value: `${f0(100 * (ratio - 1))}%`, label: 'Change in hCG', sub: 'hCG has not risen; falling levels can mean a pregnancy loss or ectopic pregnancy and need medical review', rows: { rise: `${f0(rise48)}% over 48 hours`, minimum: `At least ${minimum}% in 48 hours expected in a growing pregnancy`, note: 'Always interpret with ultrasound and your care team' } };
        }

        const doubling = (i.hours * Math.LN2) / Math.log(ratio);

        return { value: `${f1(doubling)} hours`, label: 'hCG doubling time', sub: `Rise ${f0(rise48)}% over 48 hours (${rise48 >= minimum ? 'at or above' : 'below'} the expected minimum of ${minimum}%)`, rows: { rise: `${f0(rise48)}% over 48 hours`, minimum: `At least ${minimum}% in 48 hours for a starting level ${i.h1 < 1500 ? 'under 1,500' : i.h1 < 3000 ? 'of 1,500–3,000' : 'over 3,000'} (Barnhart 2016)`, note: 'A slower rise does not always mean a problem; ultrasound and repeat tests decide' } };
    },

    fundal: (i) => {
        if (!ok(i.weeks, i.fundal) || i.weeks < 16) {
            return { empty: 'Enter weeks of pregnancy (from 16) and fundal height in cm.' };
        }

        const diff = i.fundal - i.weeks;
        const reliable = i.weeks >= 24 && i.weeks <= 36;

        return { value: `${f0(i.weeks - 2)}–${f0(i.weeks + 2)} cm`, label: `Expected fundal height at ${f0(i.weeks)} weeks`, sub: Math.abs(diff) <= 2 ? `${f1(i.fundal)} cm is within the expected range` : `${f1(i.fundal)} cm is ${f1(Math.abs(diff))} cm ${diff > 0 ? 'above' : 'below'} the weeks: the midwife or doctor may arrange a growth scan`, rows: { diff: `${diff > 0 ? '+' : ''}${f1(diff)} cm`, rule: 'From 24 to 36 weeks, fundal height in cm ≈ weeks ± 2', note: reliable ? 'Measured from the top of the pubic bone to the top of the uterus' : 'Outside 24–36 weeks the rule is less reliable' } };
    },

    mca: (i) => {
        if (!ok(i.psv, i.weeks) || i.weeks < 18 || i.weeks > 40) {
            return { empty: 'Enter the MCA peak systolic velocity and a gestational age of 18–40 weeks.' };
        }

        // Mari et al. (N Engl J Med 2000): median MCA-PSV = e^(2.31 + 0.046 × GA weeks), cm/s.
        const median = Math.exp(2.31 + 0.046 * i.weeks);
        const mom = i.psv / median;

        return { value: `${mom.toFixed(2)} MoM`, label: 'Multiples of the median', sub: mom > 1.5 ? 'Over 1.5 MoM: suggests moderate or severe fetal anaemia' : mom > 1.29 ? '1.29–1.5 MoM: possible mild anaemia' : 'Under 1.29 MoM: anaemia unlikely', rows: { median: `${f1(median)} cm/s median at ${f1(i.weeks)} weeks`, threshold: `${f1(1.5 * median)} cm/s is 1.5 MoM`, source: 'Mari et al., N Engl J Med 2000' } };
    },

    weight_gain: (i) => {
        const kg = kgOf(i.weight);
        const m = i.height;

        if (!ok(kg, m, i.weeks) || kg <= 0 || m <= 0) {
            return { empty: 'Enter height, pre-pregnancy weight and weeks of pregnancy.' };
        }

        const bmi = kg / (m * m);
        const band = [...IOM].reverse().find((b) => bmi >= b[0]);
        const twins = i.twins === 'twins';
        const total = twins ? band[6] : [band[2], band[3]];
        const w = Math.min(Math.max(i.weeks, 0), 42);
        const first = (x) => (x * Math.min(w, 13)) / 13;
        const low = w <= 13 ? first(0.5) : 0.5 + (w - 13) * band[4];
        const high = w <= 13 ? first(2) : 2 + (w - 13) * band[5];
        const gained = ok(kgOf(i.current)) && i.current > 0 ? kgOf(i.current) - kg : NaN;

        if (twins && !total) {
            return { error: 'The IOM gives no twin range for underweight; ask your care team.' };
        }

        return {
            value: `${total[0]}–${total[1]} kg`,
            label: `Recommended total gain${twins ? ' (twins, provisional)' : ''}`,
            sub: `${band[1]}, BMI ${f1(bmi)}; ${f0(total[0] * 2.2046)}–${f0(total[1] * 2.2046)} lb`,
            rows: { now: twins ? 'Weekly ranges are not set for twins' : `${f1(low)}–${f1(high)} kg by ${f0(w)} weeks`, weekly: `${band[4]}–${band[5]} kg a week in the 2nd and 3rd trimesters`, gained: !Number.isFinite(gained) ? 'Enter your current weight' : twins ? `${f1(gained)} kg so far` : `${f1(gained)} kg so far: ${gained < low ? 'below the range' : gained > high ? 'above the range' : 'within the range'}`, source: 'Institute of Medicine (2009) gestational weight gain guidelines' },
        };
    },

    sperm: (i) => {
        if (!ok(i.volume, i.concentration)) {
            return { empty: 'Enter semen volume and sperm concentration.' };
        }

        const values = { volume: i.volume, concentration: i.concentration, total: i.volume * i.concentration, motility: i.motility, progressive: i.progressive, morphology: i.morphology, vitality: i.vitality };
        const tmsc = ok(i.motility) ? (values.total * i.motility) / 100 : NaN;
        const below = WHO_SEMEN.filter(([key, , limit]) => Number.isFinite(values[key]) && values[key] < limit);

        return {
            value: Number.isFinite(tmsc) ? `${f1(tmsc)} million` : `${f1(values.total)} million`,
            label: Number.isFinite(tmsc) ? 'Total motile sperm count' : 'Total sperm number',
            sub: below.length ? `Below the WHO 2021 reference limit: ${below.map((x) => x[1].toLowerCase()).join(', ')}` : 'At or above every WHO 2021 lower reference limit entered',
            rows: { total: `${f1(values.total)} million`, progressive: ok(i.progressive) ? `${f1((values.total * i.progressive) / 100)} million progressively motile` : 'Enter progressive motility', note: 'Reference limits are the 5th centile of fertile men, not cut-offs for infertility; one test is not enough to judge', source: 'WHO laboratory manual, 6th edition (2021)' },
            grids: { limits: { columns: ['Result', 'Lower reference limit'], rows: WHO_SEMEN.map(([key, name, limit, unit]) => ({ header: name, cells: [Number.isFinite(values[key]) ? `${f1(values[key])} ${unit}` : '—', `${limit} ${unit}`], highlight: Number.isFinite(values[key]) && values[key] < limit })) } },
        };
    },

    flange: (i) => {
        if (!ok(i.nipple) || i.nipple <= 5 || i.nipple > 40) {
            return { empty: 'Enter the nipple diameter at the base, in mm.' };
        }

        const sizes = [13, 15, 17, 19, 21, 24, 27, 30, 32, 36];
        const target = i.nipple + 3;
        const best = sizes.reduce((a, b) => (Math.abs(b - target) < Math.abs(a - target) ? b : a));

        return { value: `${best} mm`, label: 'Suggested flange size', sub: `Nipple ${f0(i.nipple)} mm + about 2–4 mm: try ${f0(i.nipple + 2)}–${f0(i.nipple + 4)} mm`, rows: { range: `${f0(i.nipple + 2)}–${f0(i.nipple + 4)} mm`, fit: 'The nipple should move freely in the tunnel with little areola pulled in, and pumping should not hurt', note: 'Sizing guidance varies by brand; a lactation consultant can check the fit' } };
    },

    breastfeeding: (i) => {
        const kg = kgOf(i.weight);
        const cm = i.height * 100;

        if (!ok(kg, cm, i.age) || kg <= 0) {
            return { empty: 'Enter height, weight and age.' };
        }

        const base = eer({ age: i.age, sex: 'female', kg, cm, pa: i.pa });
        const early = i.stage !== 'late';
        const extra = (early ? 330 : 400) * (i.feeding === 'partial' ? 0.5 : 1);

        return { value: f0(base + extra), unit: 'kcal/day', label: 'Energy while breastfeeding', sub: `${f0(base)} kcal + ${f0(extra)} kcal for ${i.feeding === 'partial' ? 'partial' : 'exclusive'} breastfeeding (${early ? '0–6' : '7–12'} months)`, rows: { base: `${f0(base)} kcal (IOM EER, not breastfeeding)`, extra: `+${f0(extra)} kcal`, note: early ? 'Milk takes about 500 kcal a day; IOM allows 170 kcal from gradual weight loss in the first 6 months' : 'From 7 months, about 400 kcal a day extra with no weight-loss allowance', source: 'Institute of Medicine (2005) EER for lactation; partial feeding taken as half' } };
    },

    pecarn: (i) => {
        const under2 = i.age === 'under2';
        const high = under2 ? i.ams || i.skull : i.ams || i.basilar;
        const intermediate = under2 ? i.hematoma || i.loc || i.mechanism || i.acting : i.loc || i.vomiting || i.mechanism || i.headache;
        const risk = high ? (under2 ? 'About 4.4%' : 'About 4.3%') : intermediate ? 'About 0.9%' : under2 ? 'Under 0.02%' : 'Under 0.05%';

        return {
            value: high ? 'High risk' : intermediate ? 'Intermediate risk' : 'Very low risk',
            label: `PECARN head injury rule (${under2 ? 'under 2 years' : '2 years and older'})`,
            sub: `${risk} risk of a clinically important brain injury`,
            rows: { action: high ? 'CT is recommended' : intermediate ? 'Observation or CT, decided with the clinician and parents (worsening symptoms, multiple findings or age under 3 months favour CT)' : 'CT is not recommended', risk, source: 'Kuppermann et al., Lancet 2009 (GCS 14–15, within 24 hours of injury)' },
        };
    },

    adjusted_age: (i) => {
        const birth = parseDate(i.birth);
        const today = parseDate(i.today);
        const ga = or0(i.ga_weeks) * 7 + or0(i.ga_days);

        if (!birth || !today || ga <= 0) {
            return { empty: 'Enter the birth date, gestational age at birth and today\'s date.' };
        }

        const age = toDays(today) - toDays(birth);
        const early = Math.max(0, 280 - ga);
        const corrected = age - early;
        const text = (d) => (d < 0 ? `${weeksDays(-d)} before the due date` : d < 7 * 13 ? weeksDays(d) : `${f1(d / 30.4375)} months (${weeksDays(d)})`);

        return {
            value: text(corrected),
            label: 'Corrected (adjusted) age',
            sub: `Chronological age ${text(age)}; born ${weeksDays(early)} early`,
            rows: { chronological: text(age), early: early ? `${weeksDays(early)} (born at ${gaText(ga)} weeks)` : 'Born at term: no correction', due: shortDate(addDays(birth, early)), note: 'Use corrected age for growth and development milestones until about age 2 (AAP)' },
        };
    },

    eye_colour: (i) => {
        const result = eyeColour(i.mother ?? 'brown', i.father ?? 'blue');
        const pctText = (x) => `${f0(100 * x)}%`;
        const order = Object.entries(result).sort((a, b) => b[1] - a[1]);

        return {
            value: `${order[0][0][0].toUpperCase()}${order[0][0].slice(1)} ${pctText(order[0][1])}`,
            label: 'Most likely eye colour',
            sub: `Brown ${pctText(result.brown)}, green ${pctText(result.green)}, blue ${pctText(result.blue)}`,
            rows: { model: 'Simplified two-gene model (bey2 and gey) with equal allele frequencies', note: 'Eye colour depends on many genes (mainly OCA2 and HERC2), so real children can differ: two blue-eyed parents can have a brown-eyed child' },
            grids: { chances: { columns: ['Chance'], rows: ['brown', 'green', 'blue'].map((x) => ({ header: x[0].toUpperCase() + x.slice(1), cells: [pctText(result[x])], highlight: x === order[0][0] })) } },
        };
    },

    formula: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg) || kg <= 0) {
            return { empty: 'Enter your baby\'s weight.' };
        }

        const lb = kg / 0.45359237;
        const oz = Math.min(32, 2.5 * lb);
        const feeds = ok(i.feeds) && i.feeds > 0 ? i.feeds : 8;

        return { value: `${f0(oz)} oz (${f0(oz * OZ)} mL)`, label: 'Formula a day', sub: `About ${f1(oz / feeds)} oz (${f0((oz * OZ) / feeds)} mL) per feed over ${feeds} feeds`, rows: { rule: '2.5 oz per lb of body weight a day (about 165 mL/kg), up to 32 oz (AAP)', perFeed: `${f1(oz / feeds)} oz / ${f0((oz * OZ) / feeds)} mL`, note: 'Babies vary from feed to feed: follow hunger and fullness cues; make up formula exactly as the tin says' } };
    },

    milk: (i) => {
        const kg = kgOf(i.weight);

        if (!ok(kg) || kg <= 0) {
            return { empty: 'Enter your baby\'s weight.' };
        }

        const perKg = i.age === 'newborn' ? 150 : i.age === 'older' ? 120 : 150;
        const ml = Math.min(perKg * kg, 1000);
        const feeds = ok(i.feeds) && i.feeds > 0 ? i.feeds : 8;

        return { value: `${f0(ml)} mL (${f1(ml / OZ)} oz)`, label: 'Milk a day', sub: `About ${f0(ml / feeds)} mL (${f1(ml / OZ / feeds)} oz) per feed over ${feeds} feeds`, rows: { rule: `${perKg} mL per kg a day${i.age === 'older' ? ', with solid foods added from about 6 months' : ''}`, typical: 'Exclusively breastfed babies take about 750–800 mL a day on average from 1 to 6 months (Kent et al. 2006)', note: 'Wet nappies (6 or more a day) and weight gain are the best signs of enough milk' } };
    },

    pumping: (i) => {
        if (!ok(i.sessions, i.output)) {
            return { empty: 'Enter sessions a day and the amount per session.' };
        }

        const unitMl = i.unit === 'oz' ? OZ : 1;
        const daily = i.sessions * i.output * unitMl;
        const weeks = or0(i.weeks);
        const target = weeks < 1 ? [100, 300] : weeks < 2 ? [300, 600] : weeks < 4 ? [500, 750] : [750, 1035];
        const sessions = weeks < 12 ? '8–12 sessions a day, including one at night' : '6–8 sessions a day often maintain supply';

        return { value: `${f0(daily)} mL (${f1(daily / OZ)} oz)`, label: 'Milk pumped a day', sub: daily < target[0] ? `Below the typical ${f0(target[0])}–${f0(target[1])} mL at this age: a lactation consultant can help` : daily > target[1] ? `Above the typical ${f0(target[0])}–${f0(target[1])} mL` : `Within the typical ${f0(target[0])}–${f0(target[1])} mL a day`, rows: { target: `${f0(target[0])}–${f0(target[1])} mL (${f0(target[0] / OZ)}–${f0(target[1] / OZ)} oz) a day`, perSession: `${f0(target[0] / i.sessions)}–${f0(target[1] / i.sessions)} mL per session at ${f0(i.sessions)} sessions`, sessions } };
    },

    blood_volume: (i) => {
        const kg = kgOf(i.weight);
        const perKg = { preterm: 100, term: 85, infant: 80, child: 75, man: 70, woman: 65 }[i.group] ?? 75;

        if (!ok(kg) || kg <= 0) {
            return { empty: 'Enter weight.' };
        }

        return { value: `${f0(perKg * kg)} mL`, label: 'Estimated blood volume', sub: `${perKg} mL/kg × ${f1(kg)} kg`, rows: { perKg: `${perKg} mL/kg`, table: 'Preterm 90–105, term newborn 80–90, infant 75–80, child 70–75, adult 65–70 mL/kg', loss: `${f0(perKg * kg * 0.1)} mL is 10% of the volume` } };
    },
};

export default defineTools(handlers);
