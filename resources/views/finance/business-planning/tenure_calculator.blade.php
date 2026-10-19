<x-calc.page
    title="Tenure Calculator - SolveKit"
    description="Free tenure calculator: length of employment in years, months and days between a start and end date, with decimal years."
    lede="Work out how long you have worked somewhere."
    about="Tenure counts whole years, then whole months, then days from the start date to the end date (or today). Decimal years = days ÷ 365.2425. The median US employee tenure was 3.9 years in January 2024 (BLS). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'tenure', 'fields' => ['start', 'end']]"
    :how-to="[
        ['name' => 'Enter the start date', 'text' => ''],
        ['name' => 'Enter the end date', 'text' => 'Today by default.'],
    ]"
    :faqs="[
        ['question' => 'How long from March 11, 2019 to October 18, 2026?', 'answer' => '7 years 7 months and 7 days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start date" value="2019-03-11" type="date" />
        <x-calc.field name="end" label="End date" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <x-calc.result label="Tenure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['start' => '2019-03-11', 'end' => '2026-10-18'],
        'Short stint' => ['start' => '2025-11-03', 'end' => '2026-10-18'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'decimal' => ['label' => 'Decimal years'],
            'months' => ['label' => 'Total months'],
            'days' => ['label' => 'Total days'],
            'weeks' => ['label' => 'Weeks'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>years, months, days between dates</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
