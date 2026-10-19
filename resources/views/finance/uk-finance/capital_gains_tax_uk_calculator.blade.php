<x-calc.page
    title="Capital Gains Tax UK Calculator - SolveKit"
    description="Free UK capital gains tax calculator for 2026/27: £3,000 annual exempt amount and 18%/24% rates depending on your income."
    lede="Work out UK Capital Gains Tax."
    about="Gains above the £3,000 annual exempt amount (after losses) are taxed at 18% within your unused basic-rate band and 24% above it; the same rates apply to residential property and other assets since October 30, 2024. Your main home is usually exempt (private residence relief). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'uk_cgt', 'fields' => ['gain', 'losses', 'income'], 'data' => ['uk' => config('finance_data.uk')], 'sym' => 'GBP', 'currency' => 'GBP', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter gains and losses', 'text' => ''],
        ['name' => 'Enter your income', 'text' => 'It decides how much falls in the basic-rate band.'],
    ]"
    :faqs="[
        ['question' => 'What CGT is due on £25,000 of gains with £40,000 income?', 'answer' => '£4,663.80.'],
        ['question' => 'And for a higher-rate taxpayer?', 'answer' => '£5,280.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="gain" label="Total gains" value="25000" step="0.01" suffix="£" />
        <x-calc.field name="losses" label="Allowable losses" value="0" step="0.01" suffix="£" />
        <x-calc.field name="income" label="Taxable income (before allowance)" value="40000" step="0.01" suffix="£" />
    </div>

    <x-calc.result label="Capital Gains Tax" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['gain' => 25000, 'losses' => 0, 'income' => 40000],
        'Higher rate' => ['gain' => 25000, 'losses' => 0, 'income' => 80000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'basic' => ['label' => 'At 18%'],
            'higher' => ['label' => 'At 24%'],
            'effective' => ['label' => 'Effective rate'],
            'due' => ['label' => 'Reporting'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>taxable = gains − losses − £3,000</li>
            <li>CGT = 18% × basic band left + 24% × rest</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
