<x-calc.page
    title="EBT Calculator — Earnings Before Tax - SolveKit"
    description="Free EBT Calculator — Earnings Before Tax: EBT = EBIT − interest. Earnings before tax is profit after interest but before income tax."
    lede="Work out the earnings before tax from EBIT and interest expense."
    about="Earnings before tax is profit after interest but before income tax. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ebt_calculator_earnings_before_tax', 'fields' => ['ebit', 'interest']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBIT, Interest expense.'],
        ['name' => 'Read the result', 'text' => 'The earnings before tax appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the earnings before tax?', 'answer' => 'EBT = EBIT − interest.'],
        ['question' => 'What is the earnings before tax for EBIT $900,000, interest expense $150,000?', 'answer' => '$750,000.00.'],
        ['question' => 'And for EBIT $240,000, interest expense $60,000?', 'answer' => '$180,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Tax expense ÷ EBT is the effective tax rate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebit" label="EBIT" value="900000" step="0.01" suffix="$" />
        <x-calc.field name="interest" label="Interest expense" value="150000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Earnings before tax" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebit' => 900000, 'interest' => 150000],
        'Example B' => ['ebit' => 240000, 'interest' => 60000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EBT = EBIT − interest</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
