<x-calc.page
    title="Earnest Money Calculator - SolveKit"
    description="Free Earnest Money Calculator: deposit = price × 1–3% (convention). Earnest money shows a buyer is serious; it is credited at closing and may be lost if the buyer backs out without a contract contingency."
    lede="Work out the earnest money deposit from offer price and earnest money."
    about="Earnest money shows a buyer is serious; it is credited at closing and may be lost if the buyer backs out without a contract contingency. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'earnest_money', 'fields' => ['price', 'percent']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Offer price, Earnest money.'],
        ['name' => 'Read the result', 'text' => 'The earnest money deposit appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the earnest money deposit?', 'answer' => 'Deposit = price × 1–3% (convention).'],
        ['question' => 'What is the earnest money deposit for offer price $400,000, earnest money 2%?', 'answer' => '$8,000.00.'],
        ['question' => 'And for offer price $650,000, earnest money 1%?', 'answer' => '$6,500.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'In hot markets buyers offer more.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Offer price" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="percent" label="Earnest money" value="2" step="any" suffix="%" />
    </div>

    <x-calc.result label="Earnest money deposit" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 400000, 'percent' => 2],
        'Example B' => ['price' => 650000, 'percent' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>deposit = price × 1–3% (convention)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
