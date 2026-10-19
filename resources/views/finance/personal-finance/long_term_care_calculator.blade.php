<x-calc.page
    title="Long Term Care Calculator - SolveKit"
    description="Free long-term care cost calculator: future cost of home care, adult day care, assisted living or a nursing home from 2024 national medians, with care inflation."
    lede="Estimate long-term care costs."
    about="Starting costs are US national annual medians from the Genworth/CareScout Cost of Care Survey 2024 (home care for 44 hours a week). Costs grow at the inflation rate you choose (care costs have risen about 3–7% a year). Enter your local monthly cost to override. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'ltc', 'fields' => ['care', 'years', 'start', 'inflation', 'cost', 'hours'], 'data' => ['ltc' => config('finance_data.ltc')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Choose the type of care', 'text' => ''],
        ['name' => 'Enter years and inflation', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What do 3 years of assisted living starting in 10 years cost?', 'answer' => '$327,148.'],
        ['question' => 'And a private nursing home room starting now?', 'answer' => '$260,610.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="care" label="Type of care" :options="['homemaker' => 'Homemaker services', 'home_aide' => 'Home health aide', 'adult_day' => 'Adult day health care', 'assisted' => 'Assisted living', 'semi_private' => 'Nursing home, semi-private', 'private' => 'Nursing home, private room']" selected="assisted" />
        <x-calc.field name="years" label="Years of care" value="3" min="0" step="any" suffix="years" />
        <x-calc.field name="start" label="Starting in" value="10" min="0" step="any" suffix="years" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="inflation" label="Care cost inflation" value="4" step="any" suffix="%" />
        <x-calc.field name="cost" label="Your local monthly cost (optional)" value="" step="0.01" suffix="$" />
        <x-calc.field name="hours" label="Home care hours a week" value="44" min="0" step="any" />
    </div>

    <x-calc.result label="Total cost of care" />

    <x-calc.options :decimals="false" :examples="[
        'Assisted living' => ['care' => 'assisted', 'years' => 3, 'start' => 10, 'inflation' => 4, 'cost' => '', 'hours' => 44],
        'Nursing home now' => ['care' => 'private', 'years' => 2, 'start' => 0, 'inflation' => 4, 'cost' => '', 'hours' => 44],
        'Part-time home aide' => ['care' => 'home_aide', 'years' => 5, 'start' => 5, 'inflation' => 3, 'cost' => '', 'hours' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'first' => ['label' => 'First-year cost'],
            'monthly' => ['label' => 'Monthly then'],
            'average' => ['label' => 'Average a year'],
            'note' => ['label' => 'Who pays'],
        ]" />
        <x-calc.quick-ref heading="2024 national medians" name="types" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = Σ base × (1 + i)^(start + year)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
