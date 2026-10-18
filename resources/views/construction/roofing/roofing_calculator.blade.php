<x-calc.page
    title="Roofing Calculator - SolveKit"
    description="Free roofing calculator: roof area, squares and bundles of shingles, underlayment, drip edge and ridge for a gable or hip roof from the footprint and pitch."
    lede="Work out the shingles and roofing materials for a roof."
    about="Every plane of a roof at one pitch has an area of its footprint × √(1 + (pitch ÷ 12)²), so the whole roof is the footprint including overhangs × that factor, for gable and hip roofs alike. Most architectural shingles come 3 bundles per square (100 ft²); check the wrapper. Add about 10% waste for gable roofs and 15% for hip roofs. This also covers the roof shingle calculator."
    :calc="['engine' => 'con-roof', 'tool' => 'roofing', 'fields' => ['length', 'width', 'pitch', 'overhang', 'type', 'waste', 'bundles', 'extra', 'roll', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'overhang' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'extra' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'roll' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Enter the footprint and pitch', 'text' => 'And the overhang.'],
        ['name' => 'Choose gable or hip', 'text' => 'And the waste.'],
    ]"
    :faqs="[
        ['question' => 'How many squares is a 40 × 30 ft house at 6/12?', 'answer' => 'About 15 squares of roof with 12 in overhangs, 16.5 with 10% waste.'],
        ['question' => 'How many bundles in a square?', 'answer' => 'Usually 3 for architectural shingles.'],
        ['question' => 'Does a hip roof have more area?', 'answer' => 'Not for the same pitch and footprint; it has more waste from cuts.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Building length" value="40" min="0" placeholder="Building length">
            <label for="calc-length-unit" class="sr-only">Building length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Building width (span)" value="30" min="0" placeholder="Building width (span)">
            <label for="calc-width-unit" class="sr-only">Building width (span) unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pitch" label="Pitch (rise per 12)" value="6" min="0" step="0.5" />
    </div>

    <x-calc.field name="overhang" label="Eave and rake overhang" value="12" min="0" placeholder="Eave and rake overhang">
        <label for="calc-overhang-unit" class="sr-only">Eave and rake overhang unit</label>
        <select id="calc-overhang-unit" name="overhang-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="type" label="Roof" :options="['gable' => 'Gable', 'hip' => 'Hip']" selected="gable" />
        <x-calc.field name="waste" label="Extra for waste" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="bundles" label="Bundles per square" value="3" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="extra" label="Extra roof area (dormers etc.)" value="" min="0" placeholder="0">
            <label for="calc-extra-unit" class="sr-only">Extra roof area (dormers etc.) unit</label>
            <select id="calc-extra-unit" name="extra-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="roll" label="Underlayment per roll" value="400" min="0" placeholder="Underlayment per roll">
            <label for="calc-roll-unit" class="sr-only">Underlayment per roll unit</label>
            <select id="calc-roll-unit" name="roll-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Price per square (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Roofing" />

    <x-calc.options :examples="[
        '40 × 30 ft, 6/12 gable' => ['length' => 40, 'length-unit' => 'ft', 'width' => 30, 'width-unit' => 'ft', 'pitch' => 6, 'overhang' => 12, 'overhang-unit' => 'in', 'type' => 'gable', 'waste' => 10, 'bundles' => 3, 'roll' => 400, 'roll-unit' => 'ft2'],
        'Hip roof 50 × 30 ft, 5/12' => ['length' => 50, 'length-unit' => 'ft', 'width' => 30, 'width-unit' => 'ft', 'pitch' => 5, 'overhang' => 18, 'overhang-unit' => 'in', 'type' => 'hip', 'waste' => 15, 'bundles' => 3, 'roll' => 400, 'roll-unit' => 'ft2'],
        'Garage 24 × 24 ft, 4/12' => ['length' => 24, 'length-unit' => 'ft', 'width' => 24, 'width-unit' => 'ft', 'pitch' => 4, 'overhang' => 12, 'overhang-unit' => 'in', 'type' => 'gable', 'waste' => 10, 'bundles' => 3, 'roll' => 400, 'roll-unit' => 'ft2', 'price' => 450],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'area' => ['label' => 'Roof area'],
            'bundles' => ['label' => 'Shingle bundles'],
            'underlayment' => ['label' => 'Underlayment'],
            'drip' => ['label' => 'Drip edge'],
            'ridge' => ['label' => 'Ridge and hips'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>roof area = (L + 2o)(W + 2o) × √(1 + (pitch ÷ 12)²)</li>
            <li>squares = area × (1 + waste) ÷ 100 ft²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
