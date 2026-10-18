<x-calc.page
    title="Vinyl Siding Calculator - SolveKit"
    description="Free vinyl siding calculator: squares and boxes of vinyl siding, with starter strip and outside corner lengths."
    lede="Work out the vinyl siding, starter strip and corners for a house."
    about="Vinyl siding is sold by the square (100 ft²) in boxes, often 2 squares per box; check the box. Starter strip runs along the bottom of every wall and outside corner posts run the wall height at each outside corner. J-channel goes around every door and window."
    :calc="['engine' => 'con-finish', 'tool' => 'siding', 'fields' => ['walls', 'walls_unit', 'gables', 'gables_unit', 'openings', 'openings_unit', 'waste', 'box', 'price', 'corners', 'corner_height'], 'unitFields' => ['box' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'corner_height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'gables' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add the walls and gables', 'text' => 'And the openings.'],
        ['name' => 'Enter the box coverage', 'text' => 'And the number of outside corners.'],
    ]"
    :faqs="[
        ['question' => 'How many squares in a box of vinyl siding?', 'answer' => 'Often 2 squares (200 ft²); check the box.'],
        ['question' => 'How much starter strip do I need?', 'answer' => 'The total length of the walls at the bottom.'],
        ['question' => 'How much extra vinyl siding?', 'answer' => 'About 10%.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[40, 9], [30, 9], [40, 9], [30, 9]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="gables" label="Gables (triangles)" :columns="['base' => 'Base', 'height' => 'Height']" :rows="[[30, 7], [30, 7]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add gable" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 6.67, 2], [3, 4, 10]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="waste" label="Extra for cuts" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="box" label="Coverage per box" value="200" min="0" placeholder="Coverage per box">
            <label for="calc-box-unit" class="sr-only">Coverage per box unit</label>
            <select id="calc-box-unit" name="box-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Price per square (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="corners" label="Outside corners" value="4" min="0" step="1" />
        <x-calc.field name="corner_height" label="Corner height" value="9" min="0" placeholder="Corner height">
            <label for="calc-corner_height-unit" class="sr-only">Corner height unit</label>
            <select id="calc-corner_height-unit" name="corner_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Siding" />

    <x-calc.options :examples="[
        'House 40 × 30 ft' => ['walls' => '40 9
30 9
40 9
30 9', 'walls_unit' => 'ft', 'gables' => '30 7
30 7', 'gables_unit' => 'ft', 'openings' => '3 6.67 2
3 4 10', 'openings_unit' => 'ft', 'waste' => 10, 'box' => 200, 'box-unit' => 'ft2', 'corners' => 4, 'corner_height' => 9, 'corner_height-unit' => 'ft'],
        'Addition 16 × 12 ft' => ['walls' => '16 8
12 8
16 8', 'walls_unit' => 'ft', 'gables' => '12 4', 'gables_unit' => 'ft', 'openings' => '3 4 3', 'openings_unit' => 'ft', 'waste' => 10, 'box' => 200, 'box-unit' => 'ft2', 'corners' => 2, 'corner_height' => 8, 'corner_height-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Area'],
            'gables' => ['label' => 'Gables'],
            'boxes' => ['label' => 'Boxes'],
            'trim' => ['label' => 'Starter and corners'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>squares = (walls + gables − openings) × (1 + waste) ÷ 100 ft²</li>
            <li>starter = Σ wall lengths</li>
            <li>corners = count × height</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
