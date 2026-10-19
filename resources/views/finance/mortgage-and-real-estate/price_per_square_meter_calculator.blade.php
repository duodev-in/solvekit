<x-calc.page
    title="Price per Square Meter Calculator - SolveKit"
    description="Free Price per Square Meter Calculator: price per m² = price ÷ square meters. Price per square meter is the standard comparison outside the US."
    lede="Work out the price per square meter from price and area."
    about="Price per square meter is the standard comparison outside the US. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'price_per_square_meter', 'fields' => ['price', 'area']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price, Area.'],
        ['name' => 'Read the result', 'text' => 'The price per square meter appears as you type, with per square foot below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price per square meter?', 'answer' => 'Price per m² = price ÷ square meters.'],
        ['question' => 'What is the price per square meter for price $300,000, area 120?', 'answer' => '$2,500.00. Per square foot: $232.26.'],
        ['question' => 'And for price $640,000, area 85?', 'answer' => '$7,529.41. Per square foot: $699.51.'],
        ['question' => 'What does the result tell me?', 'answer' => '1 m² = 10.764 ft².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price" value="300000" step="0.01" suffix="$" />
        <x-calc.field name="area" label="Area" value="120" step="any" />
    </div>

    <x-calc.result label="Price per square meter" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 300000, 'area' => 120],
        'Example B' => ['price' => 640000, 'area' => 85],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Per square foot'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>price per m² = price ÷ square meters</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
