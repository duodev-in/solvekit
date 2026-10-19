<x-calc.page
    title="Consumer Surplus Calculator - SolveKit"
    description="Free Consumer Surplus Calculator: CS = ½ × Q × (P_max − P) for linear demand. Consumer surplus is the gap between what buyers would pay and what they pay."
    lede="Work out the consumer surplus from maximum price buyers would pay, market price and quantity bought."
    about="Consumer surplus is the gap between what buyers would pay and what they pay. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'consumer_surplus', 'fields' => ['willing', 'price', 'quantity']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Maximum price buyers would pay, Market price, Quantity bought.'],
        ['name' => 'Read the result', 'text' => 'The consumer surplus appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the consumer surplus?', 'answer' => 'CS = ½ × Q × (P_max − P) for linear demand.'],
        ['question' => 'What is the consumer surplus for maximum price buyers would pay $20, market price $12, quantity bought 500?', 'answer' => '$2,000.00.'],
        ['question' => 'And for maximum price buyers would pay $80, market price $50, quantity bought 1,200?', 'answer' => '$18,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Producer surplus is the matching area above supply.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="willing" label="Maximum price buyers would pay" value="20" step="0.01" suffix="$" />
        <x-calc.field name="price" label="Market price" value="12" step="0.01" suffix="$" />
        <x-calc.field name="quantity" label="Quantity bought" value="500" step="any" />
    </div>

    <x-calc.result label="Consumer surplus" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['willing' => 20, 'price' => 12, 'quantity' => 500],
        'Example B' => ['willing' => 80, 'price' => 50, 'quantity' => 1200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CS = ½ × Q × (P_max − P) for linear demand</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
