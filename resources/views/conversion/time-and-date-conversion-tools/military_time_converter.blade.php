@php
    $reference = collect(range(0, 23))->mapWithKeys(fn ($hour) => [
        sprintf('%02d00', $hour) => ($hour % 12 === 0 ? 12 : $hour % 12).':00 '.($hour < 12 ? 'AM' : 'PM'),
    ])->all();
@endphp

<x-calc.page
    title="Military Time Converter - SolveKit"
    description="Professional military time converter for 12-hour and 24-hour time formats. Convert between standard time and military time with detailed explanations and examples."
    lede="Convert 12-hour time to 24-hour military time, or military time to 12-hour."
    about="Military time counts hours from 00 to 23 with no AM or PM. For PM times from 1 PM, add 12 to the hour; 12 AM (midnight) is 0000 and 12 PM (noon) is 1200. 2400 is sometimes used for the end of a day and means the same moment as 0000 the next day."
    :calc="['engine' => 'military-time']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => '12-hour to 24-hour, or 24-hour to 12-hour.'],
        ['name' => 'Enter the time', 'text' => 'For 24-hour input, 1430, 14:30 and 14:30:15 all work.'],
    ]"
    :faqs="[
        ['question' => 'What is 3 PM in military time?', 'answer' => '1500, said fifteen hundred hours.'],
        ['question' => 'Is midnight 0000 or 2400?', 'answer' => '0000 is the start of a day. 2400 is the end of the same day and the same moment as 0000 the next day.'],
        ['question' => 'How do you say 0830?', 'answer' => 'Zero eight thirty hours.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Direction" :options="['to24' => '12-hour → 24-hour', 'to12' => '24-hour → 12-hour']" selected="to24" />

    <div data-show-when="mode:to24" class="grid grid-cols-1 gap-3 sm:grid-cols-[1fr_1fr_minmax(0,1.2fr)]">
        <x-calc.field name="hour12" label="Hour" value="2" min="1" max="12" step="1" placeholder="1 to 12" />
        <x-calc.field name="minute12" label="Minutes" value="30" min="0" max="59" step="1" placeholder="0 to 59" />
        <x-calc.segmented name="period" legend="AM or PM" :options="['am' => 'AM', 'pm' => 'PM']" selected="pm" />
    </div>

    <div data-show-when="mode:to12" hidden>
        <x-calc.field name="time24" type="text" label="24-hour time" value="1430" placeholder="e.g. 1430 or 14:30" inputmode="numeric" />
    </div>

    <x-calc.result label="24-hour time" />

    <x-calc.options :decimals="false" :examples="[
        'Midnight' => ['mode' => 'to12', 'time24' => '0000'],
        'Noon' => ['mode' => 'to12', 'time24' => '1200'],
        '6:45 PM' => ['mode' => 'to24', 'hour12' => 6, 'minute12' => 45, 'period' => 'pm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same time as" :rows="[
            't24' => ['label' => 'Military'],
            't24colon' => ['label' => '24-hour with colon'],
            't12' => ['label' => '12-hour'],
            'spoken' => ['label' => 'Spoken'],
            'since' => ['label' => 'Since midnight'],
        ]" />
        <x-calc.section heading="Hour by hour">
            <ol class="calc-list-columns-2">
                @foreach($reference as $military => $standard)
                    <li class="calc-row"><span class="calc-row-label">{{ $military }}</span><span class="calc-row-value">{{ $standard }}</span></li>
                @endforeach
            </ol>
        </x-calc.section>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 PM to 11 PM: hour + 12</li>
            <li>12 AM = 00 · 12 PM = 12</li>
            <li>24-hour to 12-hour: hour − 12 from 13 to 23</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
