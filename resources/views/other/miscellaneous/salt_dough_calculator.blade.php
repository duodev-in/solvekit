<x-calc.page
    title="Salt Dough Calculator - SolveKit"
    description="Free salt dough calculator: flour, salt and water for salt dough crafts."
    lede="Mix salt dough."
    about="Salt dough is flour, salt and water in about 2 : 1 : 1."
    :calc="['engine' => 'ot-misc', 'tool' => 'salt_dough', 'fields' => ['flour', 'unit'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much salt for 2 cups of flour?', 'answer' => '1 cups.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="flour" label="Flour (cups)" value="2" min="0" step="any" />
        <x-calc.select name="unit" label="Measure in" :options="['cups' => 'US cups', 'grams' => 'Grams']" selected="cups" />
    </div>

    <x-calc.result label="Recipe" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['flour' => 2, 'unit' => 'cups'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'salt' => ['label' => 'Salt'],
            'water' => ['label' => 'Water'],
            'bake' => ['label' => 'Baking'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
