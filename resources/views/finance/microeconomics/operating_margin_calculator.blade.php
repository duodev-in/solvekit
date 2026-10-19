<x-calc.page
    title="Operating Margin Calculator - SolveKit"
    description="Free Operating Margin Calculator: operating margin = operating income ÷ revenue. Operating margin is profit from operations per dollar of sales."
    lede="Work out the operating margin from operating income and revenue."
    about="Operating margin is profit from operations per dollar of sales. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'operating_margin', 'fields' => ['operating', 'revenue']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Operating income, Revenue.'],
        ['name' => 'Read the result', 'text' => 'The operating margin appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the operating margin?', 'answer' => 'Operating margin = operating income ÷ revenue.'],
        ['question' => 'What is the operating margin for operating income $300,000, revenue $2,000,000?', 'answer' => '15%.'],
        ['question' => 'And for operating income $45,000, revenue $380,000?', 'answer' => '11.84%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It ignores interest and taxes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="operating" label="Operating income" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="revenue" label="Revenue" value="2000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Operating margin" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['operating' => 300000, 'revenue' => 2000000],
        'Example B' => ['operating' => 45000, 'revenue' => 380000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>operating margin = operating income ÷ revenue</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
