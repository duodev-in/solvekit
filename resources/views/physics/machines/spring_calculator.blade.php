<x-calc.page
    title="Spring Calculator - SolveKit"
    description="Free compression spring calculator: spring rate, stress, deflection and solid height from wire and coil size."
    lede="Design a compression spring."
    about="A helical spring’s rate is Gd⁴/(8D³n). The Wahl factor corrects the shear stress for coil curvature."
    :calc="['engine' => 'ph-mach', 'tool' => 'spring', 'fields' => ['wire', 'd', 'Dm', 'n', 'F', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'Dm' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'F' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'pressure', 'speed', 'stiffness'])->all(), 'physics' => collect(config('physics_data'))->only(['spring_wire'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the rate of the example music-wire spring?', 'answer' => '2.55313 N/mm.'],
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
        <x-calc.field name="Dm" label="Mean coil diameter" value="20" placeholder="Mean coil diameter">
            <label for="calc-Dm-unit" class="sr-only">Mean coil diameter unit</label>
            <select id="calc-Dm-unit" name="Dm-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Active coils" value="8" min="0" step="any" />
        <x-calc.field name="F" label="Load (optional)" value="50" placeholder="Load (optional)">
            <label for="calc-F-unit" class="sr-only">Load (optional) unit</label>
            <select id="calc-F-unit" name="F-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['npm' => 'N/m', 'npmm' => 'N/mm', 'knpm' => 'kN/m', 'npcm' => 'N/cm', 'lbfpin' => 'lbf/in', 'lbfpft' => 'lbf/ft', 'kgfpmm' => 'kgf/mm']" selected="npmm" />
    </div>

    <x-calc.result label="Spring rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'npmm', 'wire' => 'music', 'd' => 2, 'd-unit' => 'mm', 'Dm' => 20, 'Dm-unit' => 'mm', 'n' => 8, 'F' => 50, 'F-unit' => 'n'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'C' => ['label' => 'Spring index D/d'],
            'stress' => ['label' => 'Shear stress at that load (Wahl-corrected)'],
            'defl' => ['label' => 'Deflection at that load'],
            'solid' => ['label' => 'Solid height (squared and ground ends)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
