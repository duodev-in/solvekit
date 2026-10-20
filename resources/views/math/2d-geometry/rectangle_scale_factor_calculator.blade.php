<x-calc.page
    title="Rectangle Scale Factor Calculator - SolveKit"
    description="Free rectangle scale factor calculator: enlarge or reduce a rectangle by a factor k, with the new sides, area (× k²) and perimeter (× k)."
    lede="Scale a rectangle."
    about="A scale factor k multiplies every length: an 8 × 5 rectangle scaled by 1.5 becomes 12 × 7.5. The perimeter also grows by k, but the area grows by k², here 2.25 times. Use the new length instead to find k."
    :calc="['engine' => 'mt-shape', 'tool' => 'scale_rect', 'fields' => ['l', 'w', 'by', 'k', 'newl', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is an 8 × 5 rectangle scaled by 1.5?', 'answer' => '12 cm × 7.5 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="l" label="Original length" value="8" min="0" step="any" />
        <x-calc.field name="w" label="Original width" value="5" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="by" label="Scale by" :options="['factor' => 'A scale factor', 'length' => 'A new length']" selected="factor" />
        <div data-show-when="by:factor" hidden>
            <x-calc.field name="k" label="Scale factor k" value="1.5" min="0" step="any" />
        </div>
        <div data-show-when="by:length" hidden>
            <x-calc.field name="newl" label="New length" value="12" min="0" step="any" />
        </div>
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />

    <x-calc.result label="Scale factor k" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['l' => 8, 'w' => 5, 'by' => 'factor', 'k' => 1.5, 'newl' => 12, 'unit' => 'cm'],
        'From length' => ['l' => 8, 'w' => 5, 'by' => 'length', 'k' => 1, 'newl' => 20, 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'size' => ['label' => 'New size'],
            'area' => ['label' => 'Area'],
            'perim' => ['label' => 'Perimeter'],
            'kind' => ['label' => 'Type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>l′ = kl, A′ = k²A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
