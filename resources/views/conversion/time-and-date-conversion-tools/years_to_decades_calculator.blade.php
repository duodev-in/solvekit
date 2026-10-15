@php
    $units = config('units.time');
    $listed = ['decade', 'century', 'millennium', 'month', 'week', 'day'];
@endphp

<x-calc.page
    title="Years to Decades Calculator - SolveKit"
    description="Professional years to decades calculator for long-term time periods. Convert years to decades, centuries, millennia with historical context and age calculations."
    lede="Convert years to decades, centuries or millennia, or back to years."
    about="A decade is 10 years, a century 100 and a millennium 1,000. Months, weeks and days use the average Gregorian year of 365.2425 days, which includes leap years."
    :calc="['engine' => 'units', 'units' => $units, 'list' => $listed, 'quickRef' => ['year:@period' => [1, 5, 10, 25, 50, 100], '@period:year' => [0.5, 1, 2, 5, 10, 20]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction and period', 'text' => 'Years to decades, centuries or millennia, or the reverse.'],
        ['name' => 'Enter the number', 'text' => 'The result and other periods update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many years are in a decade?', 'answer' => 'Ten.'],
        ['question' => 'How many decades are in a century?', 'answer' => 'Ten. A century is 100 years.'],
        ['question' => 'How many days are in a decade?', 'answer' => 'About 3,652.4 on average; a decade with three leap years has 3,653 days.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['year:@period' => 'Years → Period', '@period:year' => 'Period → Years']" selected="year:@period" />

    <x-calc.segmented name="period" legend="Period" :options="['decade' => 'Decades', 'century' => 'Centuries', 'millennium' => 'Millennia']" selected="decade" />

    <x-calc.field name="value" label="Amount" value="25" min="0" suffix="yr" suffix-ref="value-suffix" placeholder="Enter a number" />

    <x-calc.result label="Decades" />

    <x-calc.options :examples="[
        'Age 37 years' => ['value' => 37, 'direction' => 'year:@period', 'period' => 'decade'],
        '3 centuries' => ['value' => 3, 'direction' => '@period:year', 'period' => 'century'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :grow="false" :units="$units" :keys="$listed" heading="25 yr in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>decades = years ÷ 10</li>
            <li>centuries = years ÷ 100 · millennia = years ÷ 1,000</li>
            <li>1 year = 365.2425 days (average)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
