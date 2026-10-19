<x-calc.page
    title="After-tax Cost of Debt Calculator - SolveKit"
    description="Free After-tax Cost of Debt Calculator: after-tax cost = Rd × (1 − t). Interest is tax-deductible for most companies, so debt costs less after tax."
    lede="Work out the after-tax cost of debt from pre-tax cost of debt and tax rate."
    about="Interest is tax-deductible for most companies, so debt costs less after tax. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'after_tax_cost_of_debt', 'fields' => ['rate', 'tax']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Pre-tax cost of debt, Tax rate.'],
        ['name' => 'Read the result', 'text' => 'The after-tax cost of debt appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the after-tax cost of debt?', 'answer' => 'After-tax cost = Rd × (1 − t).'],
        ['question' => 'What is the after-tax cost of debt for pre-tax cost of debt 7%, tax rate 21%?', 'answer' => '5.53%.'],
        ['question' => 'And for pre-tax cost of debt 5.5%, tax rate 25%?', 'answer' => '4.125%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use the marginal tax rate; deductibility can be capped (US: 30% of adjusted taxable income).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Pre-tax cost of debt" value="7" step="any" suffix="%" />
        <x-calc.field name="tax" label="Tax rate" value="21" step="any" suffix="%" />
    </div>

    <x-calc.result label="After-tax cost of debt" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rate' => 7, 'tax' => 21],
        'Example B' => ['rate' => 5.5, 'tax' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>after-tax cost = Rd × (1 − t)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
