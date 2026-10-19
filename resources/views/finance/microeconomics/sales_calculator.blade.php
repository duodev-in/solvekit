<x-calc.page
    title="Sales Calculator - SolveKit"
    description="Free Sales Calculator: sales = price × units. Sales revenue from price and quantity."
    lede="Work out the sales from price per unit and units sold."
    about="Sales revenue from price and quantity. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'sales', 'fields' => ['price', 'units']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Price per unit, Units sold.'],
        ['name' => 'Read the result', 'text' => 'The sales appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the sales?', 'answer' => 'Sales = price × units.'],
        ['question' => 'What is the sales for price per unit $40, units sold 250?', 'answer' => '$10,000.00.'],
        ['question' => 'And for price per unit $12, units sold 900?', 'answer' => '$10,800.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Solve for price: sales ÷ units.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price per unit" value="40" step="0.01" suffix="$" />
        <x-calc.field name="units" label="Units sold" value="250" step="any" />
    </div>

    <x-calc.result label="Sales" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['price' => 40, 'units' => 250],
        'Example B' => ['price' => 12, 'units' => 900],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sales = price × units</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
