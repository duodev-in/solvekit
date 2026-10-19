<x-calc.page
    title="Cross Price Elasticity Calculator - SolveKit"
    description="Free Cross Price Elasticity Calculator: E = %ΔQ_A ÷ %ΔP_B (midpoint). Positive means substitutes (tea and coffee); negative means complements (printers and ink)."
    lede="Work out the cross-price elasticity from your figures."
    about="Positive means substitutes (tea and coffee); negative means complements (printers and ink). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cross_price_elasticity', 'fields' => ['q1', 'q2', 'p1', 'p2']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Quantity of good A before, Quantity of good A after, Price of good B before, Price of good B after.'],
        ['name' => 'Read the result', 'text' => 'The cross-price elasticity appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cross-price elasticity?', 'answer' => 'E = %ΔQ_A ÷ %ΔP_B (midpoint).'],
        ['question' => 'What is the cross-price elasticity for quantity of good A before 1,000, quantity of good A after 1,150, price of good B before $4, price of good B after $5?', 'answer' => '0.6279.'],
        ['question' => 'And for quantity of good A before 300, quantity of good A after 240, price of good B before $100, price of good B after $130?', 'answer' => '−0.8519.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Near zero means unrelated goods.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q1" label="Quantity of good A before" value="1000" step="any" />
        <x-calc.field name="q2" label="Quantity of good A after" value="1150" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p1" label="Price of good B before" value="4" step="0.01" suffix="$" />
        <x-calc.field name="p2" label="Price of good B after" value="5" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cross-price elasticity" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['q1' => 1000, 'q2' => 1150, 'p1' => 4, 'p2' => 5],
        'Example B' => ['q1' => 300, 'q2' => 240, 'p1' => 100, 'p2' => 130],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = %ΔQ_A ÷ %ΔP_B (midpoint)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
