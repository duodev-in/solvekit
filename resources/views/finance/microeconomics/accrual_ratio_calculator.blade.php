<x-calc.page
    title="Accrual Ratio Calculator - SolveKit"
    description="Free Accrual Ratio Calculator: accrual ratio = (net income − operating cash flow) ÷ average NOA. The accrual ratio measures how much of earnings come from accruals rather than cash."
    lede="Work out the accrual ratio from net income, operating cash flow and average net operating assets."
    about="The accrual ratio measures how much of earnings come from accruals rather than cash. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'accrual_ratio', 'fields' => ['income', 'ocf', 'noa']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Operating cash flow, Average net operating assets.'],
        ['name' => 'Read the result', 'text' => 'The accrual ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the accrual ratio?', 'answer' => 'Accrual ratio = (net income − operating cash flow) ÷ average NOA.'],
        ['question' => 'What is the accrual ratio for net income $1,000,000, operating cash flow $800,000, average net operating assets $5,000,000?', 'answer' => '4%.'],
        ['question' => 'And for net income $400,000, operating cash flow $520,000, average net operating assets $2,500,000?', 'answer' => '−4.8%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'High positive ratios can indicate lower earnings quality.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="income" label="Net income" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="ocf" label="Operating cash flow" value="800000" step="0.01" suffix="$" />
        <x-calc.field name="noa" label="Average net operating assets" value="5000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Accrual ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 1000000, 'ocf' => 800000, 'noa' => 5000000],
        'Example B' => ['income' => 400000, 'ocf' => 520000, 'noa' => 2500000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>accrual ratio = (net income − operating cash flow) ÷ average NOA</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
