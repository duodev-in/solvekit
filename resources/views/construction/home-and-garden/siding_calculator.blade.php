<x-calc.page
    title="Siding Calculator - SolveKit"
    description="Free siding calculator: squares of siding for walls and gables less openings, with lap siding pieces from exposure and length."
    lede="Work out the squares and pieces of siding for a house."
    about="Siding is sold by the square (100 ft²). Add walls and triangular gables, subtract doors and windows, and add about 10% for cuts. For lap siding, pieces = area ÷ (exposure × piece length); fiber-cement lap 8¼ in wide has about a 7 in exposure."
    :calc="['engine' => 'con-finish', 'tool' => 'siding', 'fields' => ['walls', 'walls_unit', 'gables', 'gables_unit', 'openings', 'openings_unit', 'waste', 'exposure', 'piece', 'price'], 'unitFields' => ['exposure' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'piece' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()], 'rowUnits' => ['walls' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'gables' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'openings' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Add the walls and gables', 'text' => 'Gables as base × height.'],
        ['name' => 'Subtract openings', 'text' => 'Doors and windows.'],
        ['name' => 'Enter the exposure', 'text' => 'For a count of lap pieces.'],
    ]"
    :faqs="[
        ['question' => 'What is a square of siding?', 'answer' => '100 ft² of wall covered.'],
        ['question' => 'How much extra siding should I order?', 'answer' => 'About 10%, more for houses with many corners and gables.'],
        ['question' => 'How do I measure a gable?', 'answer' => 'Base × height ÷ 2.'],
    ]"
>
    <x-calc.rows-editor name="walls" label="Walls" :columns="['length' => 'Length', 'height' => 'Height']" :rows="[[40, 9], [30, 9], [40, 9], [30, 9]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add wall" />

    <x-calc.rows-editor name="gables" label="Gables (triangles)" :columns="['base' => 'Base', 'height' => 'Height']" :rows="[[30, 7], [30, 7]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add gable" />

    <x-calc.rows-editor name="openings" label="Doors and windows" :columns="['width' => 'Width', 'height' => 'Height', 'count' => 'Count']" :rows="[[3, 6.67, 2], [3, 4, 10]]" :units="collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()" unit="ft" add-label="Add opening" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="waste" label="Extra for cuts" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="exposure" label="Exposure (lap siding)" value="7" min="0" placeholder="Exposure (lap siding)">
            <label for="calc-exposure-unit" class="sr-only">Exposure (lap siding) unit</label>
            <select id="calc-exposure-unit" name="exposure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="piece" label="Piece length" value="12" min="0" placeholder="Piece length">
            <label for="calc-piece-unit" class="sr-only">Piece length unit</label>
            <select id="calc-piece-unit" name="piece-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="price" label="Price per square (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />

    <x-calc.result label="Siding" />

    <x-calc.options :examples="[
        'House 40 × 30 ft' => ['walls' => '40 9
30 9
40 9
30 9', 'walls_unit' => 'ft', 'gables' => '30 7
30 7', 'gables_unit' => 'ft', 'openings' => '3 6.67 2
3 4 10', 'openings_unit' => 'ft', 'waste' => 10, 'exposure' => 7, 'exposure-unit' => 'in', 'piece' => 12, 'piece-unit' => 'ft'],
        'Garage, no gables' => ['walls' => '24 8
24 8
24 8
24 8', 'walls_unit' => 'ft', 'gables' => '', 'gables_unit' => 'ft', 'openings' => '16 7 1
3 6.67 1', 'openings_unit' => 'ft', 'waste' => 10, 'exposure' => 7, 'exposure-unit' => 'in', 'piece' => 12, 'piece-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Area'],
            'gables' => ['label' => 'Gables'],
            'pieces' => ['label' => 'Lap pieces'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>area = Σ walls + Σ base × height ÷ 2 − openings</li>
            <li>squares = area × (1 + waste) ÷ 100 ft²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
