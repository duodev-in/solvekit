<x-calc.page
    title="Donut Calculator - SolveKit"
    description="Free donut calculator: dough needed for a number of donuts from their size and thickness, a base yeast-dough recipe scaled to it, and the frying oil for your pot."
    lede="Find the dough and oil for a batch of donuts."
    about="Each ring is a flat cylinder with a hole: volume = π ÷ 4 × (outer² − hole²) × thickness. Yeast dough weighs about 1.1 g per cm³, and re-rolling the scraps loses about 10%. The base dough is flour 100%, milk 55%, eggs 20%, sugar 12%, butter 12%, salt 1.5% and instant yeast 1.5% (baker's percentages). Fry at 350–360 °F (175–180 °C) in 2–3 in of oil. Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-bake', 'tool' => 'donut', 'fields' => ['units', 'count', 'outer', 'hole', 'thickness', 'pot']]"
    :how-to="[
        ['name' => 'Enter how many donuts and their size', 'text' => ''],
        ['name' => 'Enter your pot size', 'text' => 'For the oil.'],
    ]"
    :faqs="[
        ['question' => 'How much dough for 12 three-inch donuts?', 'answer' => '748 g (about 56.6 g each).'],
        ['question' => 'And how much flour?', 'answer' => '370 g (2.96 cups).'],
    ]"
>
    <x-calc.segmented name="units" legend="Measured in" :options="['in' => 'Inches', 'cm' => 'Centimetres']" selected="in" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="count" label="Donuts" value="12" min="0" step="1" />
        <x-calc.field name="outer" label="Outer diameter" value="3" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="hole" label="Hole diameter" value="1" min="0" step="any" />
        <x-calc.field name="thickness" label="Cut thickness" value="0.5" min="0" step="any" />
        <x-calc.field name="pot" label="Pot diameter" value="10" min="0" step="any" />
    </div>

    <x-calc.result label="Dough needed" />

    <x-calc.options :decimals="false" :examples="[
        '12 classic' => ['units' => 'in', 'count' => 12, 'outer' => 3, 'hole' => 1, 'thickness' => 0.5, 'pot' => 10],
        '24 minis' => ['units' => 'in', 'count' => 24, 'outer' => 2, 'hole' => 0.75, 'thickness' => 0.5, 'pot' => 10],
        'Metric' => ['units' => 'cm', 'count' => 10, 'outer' => 8, 'hole' => 3, 'thickness' => 1.3, 'pot' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'each' => ['label' => 'Each donut'],
            'flour' => ['label' => 'Flour'],
            'rest' => ['label' => 'Other ingredients'],
            'oil' => ['label' => 'Frying oil'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = π/4 × (D² − d²) × t</li>
            <li>dough = V × 1.1 g/cm³ × count × 1.1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
