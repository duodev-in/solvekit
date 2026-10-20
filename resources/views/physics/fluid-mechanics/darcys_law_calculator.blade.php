<x-calc.page
    title="Darcy's Law Calculator - SolveKit"
    description="Free Darcy's law calculator: groundwater flow through porous media, solved for any value."
    lede="Solve Q = KAΔh ÷ L."
    about="Flow through soil or rock is proportional to the hydraulic conductivity, the area and the head gradient."
    :calc="['engine' => 'ph-fluid', 'tool' => 'darcy_law', 'fields' => ['solve', 'Q', 'K', 'A', 'dh', 'L', 'out_Q', 'out_A', 'out_dh', 'out_L'], 'unitFields' => ['Q' => collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'dh' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['Q', 'area', 'energy', 'flow', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What flows through 10 m² of sand (K = 10⁻⁴ m/s) with a 2 m drop over 20 m?', 'answer' => '0.36 m³/h.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Q' => 'Flow rate', 'K' => 'Hydraulic conductivity (m/s)', 'A' => 'Cross-section area', 'dh' => 'Head difference', 'L' => 'Flow path length']" selected="Q" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:K,A,dh,L" hidden>
            <x-calc.field name="Q" label="Flow rate" value="0.36" min="0" placeholder="Flow rate">
                <label for="calc-Q-unit" class="sr-only">Flow rate unit</label>
                <select id="calc-Q-unit" name="Q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.flow'))->only(['m3s', 'm3h', 'ls', 'lmin', 'gpm', 'cfm', 'cfs']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm3h')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,A,dh,L">
            <x-calc.field name="K" label="Hydraulic conductivity (m/s)" value="0.0001" step="any" />
        </div>
        <div data-show-when="solve:Q,K,dh,L">
            <x-calc.field name="A" label="Cross-section area" value="10" min="0" placeholder="Cross-section area">
                <label for="calc-A-unit" class="sr-only">Cross-section area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,K,A,L">
            <x-calc.field name="dh" label="Head difference" value="2" placeholder="Head difference">
                <label for="calc-dh-unit" class="sr-only">Head difference unit</label>
                <select id="calc-dh-unit" name="dh-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q,K,A,dh">
            <x-calc.field name="L" label="Flow path length" value="20" placeholder="Flow path length">
                <label for="calc-L-unit" class="sr-only">Flow path length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Q">
            <x-calc.select name="out_Q" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="m3h" />
        </div>
        <div data-show-when="solve:A" hidden>
            <x-calc.select name="out_A" label="Show the result in" :options="['m2' => 'm²', 'cm2' => 'cm²', 'mm2' => 'mm²', 'km2' => 'km²', 'ha' => 'ha', 'ft2' => 'ft²', 'in2' => 'in²', 'yd2' => 'yd²', 'acre' => 'ac']" selected="m2" />
        </div>
        <div data-show-when="solve:dh" hidden>
            <x-calc.select name="out_dh" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
    </div>

    <x-calc.result label="Flow rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Q', 'Q' => 0.36, 'Q-unit' => 'm3h', 'out_Q' => 'm3h', 'K' => 0.0001, 'A' => 10, 'A-unit' => 'm2', 'out_A' => 'm2', 'dh' => 2, 'dh-unit' => 'm', 'out_dh' => 'm', 'L' => 20, 'L-unit' => 'm', 'out_L' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'q' => ['label' => 'Darcy flux'],
            'i' => ['label' => 'Hydraulic gradient'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q = K A Δh ÷ L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
