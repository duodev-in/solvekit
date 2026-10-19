<x-calc.page
    title="APC Calculator - SolveKit"
    description="Free APC Calculator: APC = consumption ÷ disposable income. The share of income spent; 1 − APC is the average propensity to save."
    lede="Work out the average propensity to consume from consumption and disposable income."
    about="The share of income spent; 1 − APC is the average propensity to save. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'apc', 'fields' => ['consumption', 'income']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Consumption, Disposable income.'],
        ['name' => 'Read the result', 'text' => 'The average propensity to consume appears as you type, with APS below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the average propensity to consume?', 'answer' => 'APC = consumption ÷ disposable income.'],
        ['question' => 'What is the average propensity to consume for consumption $45,000, disposable income $60,000?', 'answer' => '0.75. APS: 0.25.'],
        ['question' => 'And for consumption $30,000, disposable income $30,000?', 'answer' => '1. APS: 0.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Lower-income households usually have a higher APC.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="consumption" label="Consumption" value="45000" step="0.01" suffix="$" />
        <x-calc.field name="income" label="Disposable income" value="60000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Average propensity to consume" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['consumption' => 45000, 'income' => 60000],
        'Example B' => ['consumption' => 30000, 'income' => 30000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'APS'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>APC = consumption ÷ disposable income</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
