<x-calc.page
    title="DIY Shed Cost Calculator - SolveKit"
    description="Free DIY shed cost calculator: materials list and cost for a gable-roof shed from its size, wall height and roof pitch, using your prices."
    lede="Work out the materials and cost of building a shed."
    about="Quantities come from the shed's geometry: floor, wall and roof sheathing in 4 × 8 sheets, studs at 16 in, floor joists at 16 in, rafters at 24 in and roofing squares, each with 10% extra. Costs use the prices you enter; the defaults are example prices only."
    :calc="['engine' => 'con-framing', 'tool' => 'shed_cost', 'fields' => ['length', 'width', 'wall_height', 'pitch', 'overhang', 'sheet_price', 'siding_price', 'stud_price', 'joist_price', 'roofing_price', 'other'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'wall_height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'overhang' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the shed size', 'text' => 'Length, width, wall height and pitch.'],
        ['name' => 'Enter your local prices', 'text' => 'The defaults are only examples.'],
    ]"
    :faqs="[
        ['question' => 'How much does a 12 × 8 shed cost to build?', 'answer' => 'It depends on local prices; enter them to get a figure for your area.'],
        ['question' => 'What roof pitch for a shed?', 'answer' => '4/12 is common for shingles; at least 2/12 is required for asphalt shingles with special underlayment.'],
        ['question' => 'Does this include a foundation?', 'answer' => 'No; add skids, blocks or a slab separately.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Length" value="12" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="8" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="wall_height" label="Wall height" value="8" min="0" placeholder="Wall height">
            <label for="calc-wall_height-unit" class="sr-only">Wall height unit</label>
            <select id="calc-wall_height-unit" name="wall_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pitch" label="Roof pitch (rise per 12)" value="4" min="0" step="0.5" />
        <x-calc.field name="overhang" label="Eave overhang" value="6" min="0" placeholder="Eave overhang">
            <label for="calc-overhang-unit" class="sr-only">Eave overhang unit</label>
            <select id="calc-overhang-unit" name="overhang-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="sheet_price" label="Sheathing per sheet" value="30" min="0" step="0.01" suffix="$" />
        <x-calc.field name="siding_price" label="Siding per sheet (optional)" value="45" min="0" step="0.01" suffix="$" />
        <x-calc.field name="stud_price" label="Stud price" value="5" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="joist_price" label="Joist or rafter price" value="14" min="0" step="0.01" suffix="$" />
        <x-calc.field name="roofing_price" label="Roofing per square" value="120" min="0" step="0.01" suffix="$" />
        <x-calc.field name="other" label="Door, windows, hardware" value="400" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Materials cost" />

    <x-calc.options :examples="[
        '12 × 8 ft shed' => ['length' => 12, 'length-unit' => 'ft', 'width' => 8, 'width-unit' => 'ft', 'wall_height' => 8, 'wall_height-unit' => 'ft', 'pitch' => 4, 'overhang' => 6, 'overhang-unit' => 'in', 'sheet_price' => 30, 'siding_price' => 45, 'stud_price' => 5, 'joist_price' => 14, 'roofing_price' => 120, 'other' => 400],
        '10 × 10 ft, 6/12 roof' => ['length' => 10, 'length-unit' => 'ft', 'width' => 10, 'width-unit' => 'ft', 'wall_height' => 7, 'wall_height-unit' => 'ft', 'pitch' => 6, 'overhang' => 12, 'overhang-unit' => 'in', 'sheet_price' => 30, 'siding_price' => 45, 'stud_price' => 5, 'joist_price' => 14, 'roofing_price' => 120, 'other' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'floor' => ['label' => 'Floor area'],
            'roof' => ['label' => 'Roof'],
            'walls' => ['label' => 'Walls'],
            'rafter' => ['label' => 'Rafter length'],
        ]" />
        <x-calc.quick-ref heading="Materials list" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rafter = (W ÷ 2 + overhang) × √(1 + (pitch ÷ 12)²)</li>
            <li>roof = 2 × rafter × (L + 2 × overhang)</li>
            <li>sheets = area × 1.1 ÷ 32 ft²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
