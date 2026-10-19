<x-calc.page
    title="Mutual Fund Calculator - SolveKit"
    description="Free mutual fund calculator: value of a lump sum and monthly investments in a fund after its expense ratio and any sales load."
    lede="Project a mutual fund investment after fees."
    about="Each monthly investment buys shares at the start of the month; the fund grows at its return minus the expense ratio. A front-end load is taken from each purchase. Past returns do not guarantee future ones. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'mutual_fund', 'fields' => ['start', 'monthly', 'rate', 'fee', 'load', 'years']]"
    :how-to="[
        ['name' => 'Enter the amounts', 'text' => 'Lump sum and monthly.'],
        ['name' => 'Enter return and costs', 'text' => 'From the fund\'s prospectus.'],
    ]"
    :faqs="[
        ['question' => 'What do $10,000 and $300 a month become in 20 years at 7% with a 0.5% expense ratio?', 'answer' => '$184,487.68.'],
        ['question' => 'And with a 5.75% front-end load?', 'answer' => '$164,698.84.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Lump sum" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="monthly" label="Monthly investment" value="300" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Expected return" value="7" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fee" label="Expense ratio" value="0.5" step="any" suffix="%" />
        <x-calc.field name="load" label="Front-end load" value="0" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="20" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Fund value" />

    <x-calc.options :decimals="false" :examples="[
        'No-load fund' => ['start' => 10000, 'monthly' => 300, 'rate' => 7, 'fee' => 0.5, 'load' => 0, 'years' => 20],
        'Loaded fund' => ['start' => 10000, 'monthly' => 300, 'rate' => 7, 'fee' => 0.9, 'load' => 5.75, 'years' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Balance over time" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'invested' => ['label' => 'Total invested'],
            'gain' => ['label' => 'Gain'],
            'net' => ['label' => 'Return after fees'],
            'load' => ['label' => 'Paid in loads'],
        ]" />
        <x-calc.grid heading="Year by year" name="schedule" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FV at (return − expense ratio), purchases × (1 − load)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
