<x-calc.page
    title="Price Per Square Foot Calculator - SolveKit"
    description="Free Price Per Square Foot Calculator: price per ft² = price ÷ square feet. Compare homes of different sizes by price per square foot."
    lede="Work out the price per square foot from price and area."
    about="Compare homes of different sizes by price per square foot. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_per_square_foot', 'fields' => ['price', 'area']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price, Area.'],
        ['name' => 'Read the result', 'text' => 'The price per square foot appears as you type, with per square meter below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price per square foot?', 'answer' => 'Price per ft² = price ÷ square feet.'],
        ['question' => 'What is the price per square foot for price $450,000, area 1,800?', 'answer' => '$250.00. Per square meter: $2,690.98.'],
        ['question' => 'And for price $1,250,000, area 2,700?', 'answer' => '$462.96. Per square meter: $4,983.29.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use the same measurement standard (finished above-grade area) for all.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price" value="450000" step="0.01" suffix="$" />
        <x-calc.field name="area" label="Area" value="1800" step="any" />
    </div>

    <x-calc.result label="Price per square foot" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 450000, 'area' => 1800],
        'Example B' => ['price' => 1250000, 'area' => 2700],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Per square meter'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>price per ft² = price ÷ square feet</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
