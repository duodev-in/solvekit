<x-calc.page
    title="Countersink Depth Calculator - SolveKit"
    description="Free countersink depth calculator: depth to sink a flat-head screw flush from head diameter, hole size and countersink angle (82°, 90°, 100°)."
    lede="Work out how deep to countersink for a flat-head screw."
    about="A countersink of included angle θ cut from a hole of diameter d reaches diameter D at a depth (D − d) ÷ (2 tan(θ ÷ 2)). Inch flat-head screws use 82° (aerospace 100°); metric use 90°."
    :calc="['engine' => 'con-mech', 'tool' => 'countersink', 'fields' => ['head', 'hole', 'angle', 'depth'], 'unitFields' => ['head' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'hole' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the head and hole', 'text' => 'Head diameter from the screw table.'],
        ['name' => 'Choose the angle', 'text' => '82° for inch, 90° for metric.'],
    ]"
    :faqs="[
        ['question' => 'How deep for a ¼ in flat-head screw?', 'answer' => 'About 0.140 in for an 82° countersink with a 0.5 in head and a 0.257 in hole.'],
        ['question' => 'Why 82°?', 'answer' => 'Unified inch flat-head screws have 82° heads (ASME B18.6.3).'],
        ['question' => 'What angle for metric?', 'answer' => '90° (ISO 10642, ISO 7046).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="head" label="Head diameter" value="0.5" min="0" placeholder="Head diameter">
            <label for="calc-head-unit" class="sr-only">Head diameter unit</label>
            <select id="calc-head-unit" name="head-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hole" label="Hole diameter" value="0.257" min="0" placeholder="Hole diameter">
            <label for="calc-hole-unit" class="sr-only">Hole diameter unit</label>
            <select id="calc-hole-unit" name="hole-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="angle" label="Angle" :options="['82' => '82° (inch screws)', '90' => '90° (metric)', '100' => '100° (aircraft)', '60' => '60°', '120' => '120°']" selected="82" />
    </div>

    <x-calc.field name="depth" label="Check a depth (optional)" value="" min="0" placeholder="Optional">
        <label for="calc-depth-unit" class="sr-only">Check a depth (optional) unit</label>
        <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Countersink depth" />

    <x-calc.options :examples="[
        '¼ in screw, 82°' => ['head' => 0.5, 'head-unit' => 'in', 'hole' => 0.257, 'hole-unit' => 'in', 'angle' => '82'],
        'M6, 90°' => ['head' => 12, 'head-unit' => 'mm', 'hole' => 6.6, 'hole-unit' => 'mm', 'angle' => '90'],
        '#10 at 100°' => ['head' => 0.385, 'head-unit' => 'in', 'hole' => 0.201, 'hole-unit' => 'in', 'angle' => '100'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mm' => ['label' => 'Millimeters'],
            'sharp' => ['label' => 'From a point'],
            'diameter' => ['label' => 'Diameter at depth'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>depth = (D − d) ÷ (2 tan(θ ÷ 2))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
