<x-calc.page
    title="Percent Off Calculator - SolveKit"
    description="Free Percent Off Calculator: price after = price × (1 − percent off). Price after a percent-off sale."
    lede="Work out the price after discount from price and percent off."
    about="Price after a percent-off sale. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'percent_off', 'fields' => ['price', 'off']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price, Percent off.'],
        ['name' => 'Read the result', 'text' => 'The price after discount appears as you type, with saved below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the price after discount?', 'answer' => 'Price after = price × (1 − percent off).'],
        ['question' => 'What is the price after discount for price $200, percent off 30%?', 'answer' => '$140.00. Saved: $60.00.'],
        ['question' => 'And for price $64, percent off 40%?', 'answer' => '$38.40. Saved: $25.60.'],
        ['question' => 'What does the result tell me?', 'answer' => '30% off $200 is $140.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price" value="200" step="0.01" suffix="$" />
        <x-calc.field name="off" label="Percent off" value="30" step="any" suffix="%" />
    </div>

    <x-calc.result label="Price after discount" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 200, 'off' => 30],
        'Example B' => ['price' => 64, 'off' => 40],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Saved'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>price after = price × (1 − percent off)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
