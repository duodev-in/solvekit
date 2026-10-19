<x-calc.page
    title="Software Contract Value Calculator - SolveKit"
    description="Free Software Contract Value Calculator: TCV = annual subscription × years + one-time fees. Total contract value counts all revenue in a contract; annual contract value spreads it over the years."
    lede="Work out the total contract value from annual subscription, contract term and one-time fees."
    about="Total contract value counts all revenue in a contract; annual contract value spreads it over the years. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'software_contract_value', 'fields' => ['subscription', 'years', 'onetime']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Annual subscription, Contract term, One-time fees.'],
        ['name' => 'Read the result', 'text' => 'The total contract value appears as you type, with annual contract value (with fees), annual recurring revenue below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the total contract value?', 'answer' => 'TCV = annual subscription × years + one-time fees; ACV = TCV ÷ years.'],
        ['question' => 'What is the total contract value for annual subscription $24,000, contract term 3 years, one-time fees $5,000?', 'answer' => '$77,000.00. Annual contract value (with fees): $25,666.67.'],
        ['question' => 'And for annual subscription $12,000, contract term 2 years, one-time fees $0?', 'answer' => '$24,000.00. Annual contract value (with fees): $12,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Some companies exclude one-time fees from ACV; this shows both.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="subscription" label="Annual subscription" value="24000" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Contract term" value="3" min="0" step="any" suffix="years" />
        <x-calc.field name="onetime" label="One-time fees" value="5000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Total contract value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['subscription' => 24000, 'years' => 3, 'onetime' => 5000],
        'Example B' => ['subscription' => 12000, 'years' => 2, 'onetime' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Annual contract value (with fees)'],
            'r2' => ['label' => 'Annual recurring revenue'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TCV = annual subscription × years + one-time fees</li>
            <li>ACV = TCV ÷ years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
