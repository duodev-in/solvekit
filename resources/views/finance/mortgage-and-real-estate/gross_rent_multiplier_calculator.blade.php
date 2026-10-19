<x-calc.page
    title="Gross Rent Multiplier Calculator - SolveKit"
    description="Free Gross Rent Multiplier Calculator: GRM = price ÷ gross annual rent. GRM is a quick screen comparing price with rent, ignoring expenses."
    lede="Work out the gross rent multiplier from property price and gross annual rent."
    about="GRM is a quick screen comparing price with rent, ignoring expenses. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gross_rent_multiplier', 'fields' => ['price', 'rent']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Property price, Gross annual rent.'],
        ['name' => 'Read the result', 'text' => 'The gross rent multiplier appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the gross rent multiplier?', 'answer' => 'GRM = price ÷ gross annual rent.'],
        ['question' => 'What is the gross rent multiplier for property price $600,000, gross annual rent $72,000?', 'answer' => '8.333×.'],
        ['question' => 'And for property price $240,000, gross annual rent $26,400?', 'answer' => '9.091×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Lower GRM means more rent per dollar of price.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Property price" value="600000" step="0.01" suffix="$" />
        <x-calc.field name="rent" label="Gross annual rent" value="72000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Gross rent multiplier" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 600000, 'rent' => 72000],
        'Example B' => ['price' => 240000, 'rent' => 26400],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GRM = price ÷ gross annual rent</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
