<x-calc.page
    title="Miles per Year Calculator - SolveKit"
    description="Free miles per year calculator: annual mileage from two odometer readings and their dates, or from daily driving, with monthly and weekly figures."
    lede="Work out how many miles you drive a year."
    about="From two odometer readings, miles a year = miles between them ÷ days between them × 365.25. From habits, miles a year = miles a day × days a week ÷ 7 × 365.25. Useful for insurance quotes, leases and buying a used car."
    :calc="['engine' => 'ev-transport', 'tool' => 'miles_per_year', 'fields' => ['mode', 'start_miles', 'start_date', 'end_miles', 'end_date', 'daily', 'days_week', 'unit']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Odometer readings or daily driving.'],
        ['name' => 'Enter the numbers', 'text' => 'And whether they are miles or km.'],
    ]"
    :faqs="[
        ['question' => 'How many miles a year is normal?', 'answer' => 'Many leases allow 10,000–15,000 miles a year.'],
        ['question' => 'How do I find my mileage from two readings?', 'answer' => 'Divide the miles between them by the days and multiply by 365.25.'],
        ['question' => 'Is 9,730 miles in 350 days a lot?', 'answer' => 'That is about 10,150 miles a year.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['odometer' => 'Odometer readings', 'daily' => 'Daily driving']" selected="odometer" />

    <div data-show-when="mode:odometer">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="start_miles" label="First reading" value="41250" min="0" step="1" />
            <x-calc.field name="start_date" label="Date" value="2025-11-02" type="date" />
        </div>
    </div>

    <div data-show-when="mode:odometer">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="end_miles" label="Second reading" value="50980" min="0" step="1" />
            <x-calc.field name="end_date" label="Date" value="2026-10-18" type="date" />
        </div>
    </div>

    <div data-show-when="mode:daily" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="daily" label="Miles or km a day" value="32" min="0" step="1" />
            <x-calc.field name="days_week" label="Days a week" value="5" min="1" max="7" step="1" />
        </div>
    </div>

    <x-calc.segmented name="unit" legend="Readings in" :options="['mi' => 'Miles', 'km' => 'Kilometers']" selected="mi" />

    <x-calc.result label="Distance a year" />

    <x-calc.options :examples="[
        'Two readings' => ['mode' => 'odometer', 'start_miles' => 41250, 'start_date' => '2025-11-02', 'end_miles' => 50980, 'end_date' => '2026-10-18', 'daily' => '', 'days_week' => '', 'unit' => 'mi'],
        '32 mi a day, 5 days' => ['mode' => 'daily', 'start_miles' => '', 'start_date' => '', 'end_miles' => '', 'end_date' => '', 'daily' => 32, 'days_week' => 5, 'unit' => 'mi'],
        'Metric readings' => ['mode' => 'odometer', 'start_miles' => 12000, 'start_date' => '2026-01-10', 'end_miles' => 19500, 'end_date' => '2026-09-30', 'daily' => '', 'days_week' => '', 'unit' => 'km'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'month' => ['label' => 'Per month'],
            'week' => ['label' => 'Per week'],
            'day' => ['label' => 'Per day'],
            'other' => ['label' => 'Other unit'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>miles a year = Δmiles ÷ Δdays × 365.25</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
