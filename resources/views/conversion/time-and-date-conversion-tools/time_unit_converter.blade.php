@php
    $units = config('units.time');
@endphp

<x-calc.page
    title="Time Unit Converter - SolveKit"
    description="Professional time unit converter for all time measurements. Convert between seconds, minutes, hours, days, weeks, months, and years with precision calculations."
    lede="Convert between seconds, minutes, hours, days, weeks, months and years."
    about="Every unit converts through the second. Months and years have no fixed length, so they use Gregorian calendar averages: a year is 365.2425 days and a month is one twelfth of that (30.436875 days). That keeps 12 months exactly equal to 1 year."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a duration', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How many seconds are in a day?', 'answer' => '86,400.'],
        ['question' => 'How long is a month in this converter?', 'answer' => '30.436875 days, the average Gregorian month. Calendar months are 28 to 31 days.'],
        ['question' => 'How many days are in a year?', 'answer' => '365.2425 on average in the Gregorian calendar, which accounts for leap years.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="h" to="min" value="2.5" min="0" label="Duration" />

    <x-calc.result label="Minutes">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Movie 135 min' => ['value' => 135, 'from' => 'min'],
        'Project 6 weeks' => ['value' => 6, 'from' => 'week'],
        'Lifetime 80 years' => ['value' => 80, 'from' => 'year'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="2.5 h in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>result = value × (from unit in s) ÷ (to unit in s)</li>
            <li>1 day = 86,400 s</li>
            <li>1 year = 365.2425 days</li>
            <li>1 month = 1/12 year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
