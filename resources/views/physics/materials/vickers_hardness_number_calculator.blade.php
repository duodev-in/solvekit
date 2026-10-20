<x-calc.page
    title="Vickers Hardness Number Calculator - SolveKit"
    description="Free Vickers hardness calculator: HV from test force and the indentation diagonals."
    lede="Find the Vickers hardness."
    about="A diamond pyramid leaves a square dent. HV = 1.8544 F/d² with F in kgf and the mean diagonal d in mm."
    :calc="['engine' => 'ph-mat', 'tool' => 'vickers', 'fields' => ['F', 'd1', 'd2'], 'unitFields' => ['F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'd1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is HV for 10 kgf and diagonals of 0.30 and 0.31 mm?', 'answer' => '199.3 HV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="F" label="Test force" value="10" placeholder="Test force">
            <label for="calc-F-unit" class="sr-only">Test force unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kgf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d1" label="Diagonal 1" value="0.3" placeholder="Diagonal 1">
            <label for="calc-d1-unit" class="sr-only">Diagonal 1 unit</label>
            <select id="calc-d1-unit" name="d1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d2" label="Diagonal 2" value="0.31" placeholder="Diagonal 2">
            <label for="calc-d2-unit" class="sr-only">Diagonal 2 unit</label>
            <select id="calc-d2-unit" name="d2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Vickers hardness" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['F' => 10, 'F-unit' => 'kgf', 'd1' => 0.3, 'd1-unit' => 'mm', 'd2' => 0.31, 'd2-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'd' => ['label' => 'Mean diagonal'],
            'depth' => ['label' => 'Indentation depth'],
            'uts' => ['label' => 'Approximate tensile strength (steels)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
