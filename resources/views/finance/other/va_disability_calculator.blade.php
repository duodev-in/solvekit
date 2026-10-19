<x-calc.page
    title="VA Disability Calculator - SolveKit"
    description="Free VA disability calculator: combined disability rating from individual ratings using VA math (38 CFR 4.25), rounded to the nearest 10, with the 2026 monthly compensation."
    lede="Work out your combined VA rating and pay."
    about="VA does not add ratings. The highest rating is applied first to a whole person; each next rating applies only to the remaining efficiency. The result is rounded to the nearest 10 (5 rounds up). Monthly pay shown is for a veteran with no dependents from December 1, 2025; the bilateral factor is not included. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'va_disability', 'fields' => ['ratings'], 'data' => ['vadisability' => config('finance_data.vadisability')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter each rating', 'text' => ''],
        ['name' => 'Read the combined rating', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the combined rating of 50, 30, 20 and 10?', 'answer' => '70% (74.8% exactly), $1,808.45 a month (veteran alone, 2026 (from December 1, 2025)).'],
        ['question' => 'And 70 and 40?', 'answer' => '80%.'],
    ]"
>
    <x-calc.textarea name="ratings" label="Individual ratings in %" value="50, 30, 20, 10" rows="2" />

    <x-calc.result label="Combined VA rating" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['ratings' => '50, 30, 20, 10'],
        'Two ratings' => ['ratings' => '70, 40'],
        'Single 30%' => ['ratings' => '30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pay' => ['label' => 'Monthly compensation'],
            'year' => ['label' => 'A year'],
            'exact' => ['label' => 'Exact combined value'],
            'note' => ['label' => 'Dependents'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>combined = 100 − Π (100 − rᵢ) ÷ 100^(n−1)</li>
            <li>round to the nearest 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
