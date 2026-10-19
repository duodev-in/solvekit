<x-calc.page
    title="Net Operating Income Calculator - SolveKit"
    description="Free Net Operating Income Calculator: NOI = gross rent × (1 − vacancy) + other income − operating expenses. NOI excludes mortgage payments, depreciation and income tax."
    lede="Work out the net operating income from your figures."
    about="NOI excludes mortgage payments, depreciation and income tax. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_operating_income', 'fields' => ['gross', 'vacancy', 'other', 'expenses']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Gross potential rent, Vacancy and credit loss, Other income, Operating expenses.'],
        ['name' => 'Read the result', 'text' => 'The net operating income appears as you type, with effective gross income below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the net operating income?', 'answer' => 'NOI = gross rent × (1 − vacancy) + other income − operating expenses.'],
        ['question' => 'What is the net operating income for gross potential rent $120,000, vacancy and credit loss 5%, other income $3,000, operating expenses $45,000?', 'answer' => '$72,000.00. Effective gross income: $117,000.00.'],
        ['question' => 'And for gross potential rent $48,000, vacancy and credit loss 8%, other income $0, operating expenses $17,000?', 'answer' => '$27,160.00. Effective gross income: $44,160.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'NOI ÷ value is the cap rate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gross" label="Gross potential rent" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="vacancy" label="Vacancy and credit loss" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="other" label="Other income" value="3000" step="0.01" suffix="$" />
        <x-calc.field name="expenses" label="Operating expenses" value="45000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Net operating income" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['gross' => 120000, 'vacancy' => 5, 'other' => 3000, 'expenses' => 45000],
        'Example B' => ['gross' => 48000, 'vacancy' => 8, 'other' => 0, 'expenses' => 17000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Effective gross income'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NOI = gross rent × (1 − vacancy) + other income − operating expenses</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
