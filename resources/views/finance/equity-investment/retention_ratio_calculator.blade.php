<x-calc.page
    title="Retention Ratio Calculator - SolveKit"
    description="Free Retention Ratio Calculator: retention = (net income − dividends) ÷ net income. The retention (plowback) ratio is the share of profit kept in the business."
    lede="Work out the retention ratio from net income and dividends."
    about="The retention (plowback) ratio is the share of profit kept in the business. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'retention_ratio', 'fields' => ['income', 'dividends']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Dividends.'],
        ['name' => 'Read the result', 'text' => 'The retention ratio appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the retention ratio?', 'answer' => 'Retention = (net income − dividends) ÷ net income.'],
        ['question' => 'What is the retention ratio for net income $5,000,000, dividends $1,500,000?', 'answer' => '70%.'],
        ['question' => 'And for net income $800,000, dividends $600,000?', 'answer' => '25%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Sustainable growth = ROE × retention ratio.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Net income" value="5000000" step="0.01" suffix="$" />
        <x-calc.field name="dividends" label="Dividends" value="1500000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Retention ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 5000000, 'dividends' => 1500000],
        'Example B' => ['income' => 800000, 'dividends' => 600000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>retention = (net income − dividends) ÷ net income</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
