<x-calc.page
    title="Torsion Spring Calculator - SolveKit"
    description="Free torsion spring calculator: torque per degree from wire size, coil diameter, coils and leg lengths."
    lede="Find a torsion spring’s rate."
    about="A torsion spring bends its wire rather than twisting it, so its rate uses Young’s modulus: k = Ed⁴/(64 D N_a). The legs add a little to the active coils."
    :calc="['engine' => 'ph-mach', 'tool' => 'torsion_spring', 'fields' => ['wire', 'd', 'Dm', 'n', 'L1', 'L2', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'Dm' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'rotational_stiffness', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['spring_wire'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the rate of the example spring?', 'answer' => '0.00876066 N·m/°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="wire" label="Wire material" :options="['music' => 'Music wire (ASTM A228)', 'oil_tempered' => 'Oil-tempered (A229)', 'hard_drawn' => 'Hard-drawn steel (A227)', 'chrome_silicon' => 'Chrome-silicon (A401)', 'stainless302' => 'Stainless 302 (A313)', 'phosphor_bronze' => 'Phosphor bronze (B159)']" selected="music" />
        <x-calc.field name="d" label="Wire diameter" value="2" placeholder="Wire diameter">
            <label for="calc-d-unit" class="sr-only">Wire diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Dm" label="Mean coil diameter" value="16" placeholder="Mean coil diameter">
            <label for="calc-Dm-unit" class="sr-only">Mean coil diameter unit</label>
            <select id="calc-Dm-unit" name="Dm-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Body coils" value="6" min="0" step="any" />
        <x-calc.field name="L1" label="Leg 1 length" value="25" placeholder="Leg 1 length">
            <label for="calc-L1-unit" class="sr-only">Leg 1 length unit</label>
            <select id="calc-L1-unit" name="L1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L2" label="Leg 2 length" value="25" placeholder="Leg 2 length">
            <label for="calc-L2-unit" class="sr-only">Leg 2 length unit</label>
            <select id="calc-L2-unit" name="L2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['nmrad' => 'N·m/rad', 'nmdeg' => 'N·m/°', 'knmrad' => 'kN·m/rad', 'lbfinrad' => 'lbf·in/rad', 'lbfindeg' => 'lbf·in/°']" selected="nmdeg" />
    </div>

    <x-calc.result label="Torsional rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'nmdeg', 'wire' => 'music', 'd' => 2, 'd-unit' => 'mm', 'Dm' => 16, 'Dm-unit' => 'mm', 'n' => 6, 'L1' => 25, 'L1-unit' => 'mm', 'L2' => 25, 'L2-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rad' => ['label' => 'Per radian'],
            'Na' => ['label' => 'Active coils including the legs'],
            'nmm' => ['label' => 'In N·mm per degree'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
