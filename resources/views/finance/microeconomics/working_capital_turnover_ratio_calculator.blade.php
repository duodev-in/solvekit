<x-calc.page
    title="Working Capital Turnover Ratio Calculator - SolveKit"
    description="Free Working Capital Turnover Ratio Calculator: turnover = revenue ÷ average working capital. How efficiently working capital supports sales."
    lede="Work out the working capital turnover from revenue and average working capital."
    about="How efficiently working capital supports sales. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'working_capital_turnover_ratio', 'fields' => ['revenue', 'wc']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Average working capital.'],
        ['name' => 'Read the result', 'text' => 'The working capital turnover appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the working capital turnover?', 'answer' => 'Turnover = revenue ÷ average working capital.'],
        ['question' => 'What is the working capital turnover for revenue $2,000,000, average working capital $400,000?', 'answer' => '5×.'],
        ['question' => 'And for revenue $600,000, average working capital $150,000?', 'answer' => '4×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Very high ratios can mean too little working capital.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Revenue" value="2000000" step="0.01" suffix="$" />
        <x-calc.field name="wc" label="Average working capital" value="400000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Working capital turnover" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 2000000, 'wc' => 400000],
        'Example B' => ['revenue' => 600000, 'wc' => 150000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>turnover = revenue ÷ average working capital</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
