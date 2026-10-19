<x-calc.page
    title="Cake Pricing Calculator - SolveKit"
    description="Free cake pricing calculator: the price to charge for a cake from ingredient costs, your time, packaging, overhead and profit margin, with the price per serving in your currency."
    lede="Price a cake from your costs, time and margin."
    about="Cost = ingredients + labour (hours × hourly rate) + packaging, plus an overhead percentage for electricity, equipment and fees. Price = cost ÷ (1 − margin): a 30% margin means 30% of the price is profit. Compare the result with local bakery prices; a home baker's hourly rate is often the part left out."
    :calc="['engine' => 'fd-bake', 'tool' => 'cake_price', 'fields' => ['costs', 'hours', 'rate', 'packaging', 'overhead', 'margin', 'servings']]"
    :how-to="[
        ['name' => 'List ingredient costs', 'text' => ''],
        ['name' => 'Enter your time and rate', 'text' => ''],
        ['name' => 'Set overhead and margin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What should I charge for a cake costing $22.70 in ingredients and 3 hours?', 'answer' => '$136.24 at a 30% margin.'],
        ['question' => 'What is the price per serving?', 'answer' => '$5.68 a serving (cost $3.97).'],
    ]"
>
    <x-calc.rows-editor name="costs" label="Ingredient costs" :columns="['name' => 'Item', 'cost' => 'Cost']" :rows="[['Flour and sugar', '4.50'], ['Butter', '6'], ['Eggs', '2.40'], ['Cream cheese frosting', '7.80'], ['Vanilla and extras', '2']]" add-label="Add item" :text="['name', 'cost']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="hours" label="Hours of work" value="3" min="0" step="any" suffix="h" />
        <x-calc.field name="rate" label="Hourly rate" value="20" min="0" step="0.01" suffix="$" />
        <x-calc.field name="packaging" label="Box and board" value="4" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="overhead" label="Overhead" value="10" min="0" step="any" suffix="%" />
        <x-calc.field name="margin" label="Profit margin" value="30" min="0" max="95" step="any" suffix="%" />
        <x-calc.field name="servings" label="Servings" value="24" min="0" step="1" />
    </div>

    <x-calc.result label="Price to charge" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['costs' => 'Flour and sugar	4.50
Butter	6
Eggs	2.40
Cream cheese frosting	7.80
Vanilla and extras	2', 'hours' => 3, 'rate' => 20, 'packaging' => 4, 'overhead' => 10, 'margin' => 30, 'servings' => 24],
        'No labour charged' => ['costs' => 'Flour and sugar	4.50
Butter	6
Eggs	2.40
Cream cheese frosting	7.80
Vanilla and extras	2', 'hours' => 0, 'rate' => 20, 'packaging' => 4, 'overhead' => 10, 'margin' => 30, 'servings' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ingredients' => ['label' => 'Ingredients'],
            'labor' => ['label' => 'Labour'],
            'overhead' => ['label' => 'Overhead'],
            'cost' => ['label' => 'Total cost'],
            'perServing' => ['label' => 'Per serving'],
            'markup' => ['label' => 'Markup'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = ingredients + hours × rate + packaging + overhead</li>
            <li>price = cost ÷ (1 − margin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
