<x-calc.page
    title="Social Security Break-Even Calculator - SolveKit"
    description="Free Social Security break-even calculator: monthly benefits when claiming at 62, full retirement age or 70, and the ages at which waiting pays off."
    lede="Compare claiming Social Security early or late."
    about="Your full retirement age (FRA) depends on your birth year: 67 for 1960 and later. Claiming early cuts the benefit by 5/9 of 1% a month for 36 months and 5/12 of 1% beyond; waiting past FRA adds 2/3 of 1% a month (8% a year) until 70. The break-even age is when total benefits from waiting catch up. Your PIA is on your my Social Security statement. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'ss_breakeven', 'fields' => ['born', 'pia', 'cola']]"
    :how-to="[
        ['name' => 'Enter your birth year', 'text' => 'For the full retirement age.'],
        ['name' => 'Enter your PIA', 'text' => 'From your SSA statement.'],
    ]"
    :faqs="[
        ['question' => 'When does waiting until 70 beat claiming at 62 for someone born in 1964 with a $2,000 PIA?', 'answer' => '83 and 6 months; $1,400.00 a month (70% of your benefit) at 62 against $2,480.00 a month (124%) at 70.'],
        ['question' => 'How much less is the benefit at 62?', 'answer' => '30% less for anyone born in 1960 or later.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="born" label="Birth year" value="1964" min="1900" step="1" />
        <x-calc.field name="pia" label="Monthly benefit at full retirement age (PIA)" value="2000" step="0.01" suffix="$" />
        <x-calc.field name="cola" label="Yearly COLA" value="2.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Break-even age, 62 vs 70" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['born' => 1964, 'pia' => 2000, 'cola' => 2.5],
        'No COLA' => ['born' => 1964, 'pia' => 2000, 'cola' => 0],
        'Born 1957' => ['born' => 1957, 'pia' => 2500, 'cola' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Total benefits received" name="chart" />
        <x-calc.rows heading="Details" :rows="[
            'fra' => ['label' => 'Full retirement age'],
            'at62' => ['label' => 'Claim at 62'],
            'atFra' => ['label' => 'Claim at FRA'],
            'at70' => ['label' => 'Claim at 70'],
            'be62fra' => ['label' => 'Break-even 62 vs FRA'],
            'befra70' => ['label' => 'Break-even FRA vs 70'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>early: −5/9% a month (36 months), −5/12% beyond</li>
            <li>delayed: +2/3% a month to 70</li>
            <li>break-even: first age where Σ benefits(later) ≥ Σ benefits(earlier)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
