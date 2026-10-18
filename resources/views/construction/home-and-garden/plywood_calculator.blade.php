<x-calc.page
    title="Plywood Calculator - SolveKit"
    description="Free plywood calculator: sheets of plywood or OSB for floors, walls and roofs from their areas."
    lede="Work out the sheets of plywood or OSB for floors, walls or roofs."
    about="Sheets = total area × (1 + waste) ÷ sheet area. A 4 × 8 ft sheet covers 32 ft². For roofs, enter the sloped roof area (the Roofing Calculator gives it from the footprint and pitch)."
    :calc="['engine' => 'con-finish', 'tool' => 'plywood', 'fields' => ['areas', 'areas_unit', 'sheet', 'waste', 'price'], 'rowUnits' => ['areas' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add each area', 'text' => 'Floors, walls or roof planes.'],
        ['name' => 'Choose the sheet size', 'text' => 'And waste.'],
    ]"
    :faqs="[
        ['question' => 'How many sheets of plywood for a 24 × 16 floor?', 'answer' => '12 sheets of 4 × 8 before waste, 14 with 10%.'],
        ['question' => 'How many square feet in a sheet?', 'answer' => '32 ft² for 4 × 8.'],
        ['question' => 'How much waste for roof sheathing?', 'answer' => '10–15% on hip roofs with many cuts.'],
    ]"
>
    <x-calc.rows-editor name="areas" label="Areas" :columns="['length' => 'Length', 'width' => 'Width']" :rows="[[24, 16], [12, 8]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add area" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="sheet" label="Sheet size" :options="['4x8' => '4 × 8 ft', '4x9' => '4 × 9 ft', '4x10' => '4 × 10 ft', '4x12' => '4 × 12 ft']" selected="4x8" />
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per sheet (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Sheets needed" />

    <x-calc.options :examples="[
        'Subfloor 24 × 16 ft' => ['areas' => '24 16', 'areas_unit' => 'ft', 'sheet' => '4x8', 'waste' => 10],
        'Shed walls and roof' => ['areas' => '10 7
8 7
10 7
8 7
10 5
10 5', 'areas_unit' => 'ft', 'sheet' => '4x8', 'waste' => 10],
        'Metric floor' => ['areas' => '6 4', 'areas_unit' => 'm', 'sheet' => '4x8', 'waste' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Area'],
            'sheet' => ['label' => 'Sheet'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sheets = ⌈Σ areas × (1 + waste) ÷ sheet area⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
