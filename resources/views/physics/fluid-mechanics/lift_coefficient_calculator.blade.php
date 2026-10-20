<x-calc.page
    title="Lift Coefficient Calculator - SolveKit"
    description="Free lift coefficient calculator: C_L = 2L/(ρv²S), solved for any value."
    lede="Solve C_L = 2L ÷ ρv²S."
    about="The lift coefficient captures how effectively a wing makes lift at its angle of attack. Cruise is typically 0.3–0.6; clean stall about 1.5."
    :calc="['engine' => 'ph-fluid', 'tool' => 'lift_coefficient', 'fields' => ['solve', 'CL', 'L', 'rho', 'v', 'S', 'out_L', 'out_rho', 'out_v', 'out_S'], 'unitFields' => ['L' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'S' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['CL', 'area', 'density', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What C_L does the example aircraft need?', 'answer' => '0.410774.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['CL' => 'Lift coefficient', 'L' => 'Lift', 'rho' => 'Air density', 'v' => 'Speed', 'S' => 'Wing area']" selected="CL" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:L,rho,v,S" hidden>
            <x-calc.field name="CL" label="Lift coefficient" value="0.4" step="any" />
        </div>
        <div data-show-when="solve:CL,rho,v,S">
            <x-calc.field name="L" label="Lift" value="10787" placeholder="Lift">
                <label for="calc-L-unit" class="sr-only">Lift unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:CL,L,v,S">
            <x-calc.field name="rho" label="Air density" value="1.225" min="0" placeholder="Air density">
                <label for="calc-rho-unit" class="sr-only">Air density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:CL,L,rho,S">
            <x-calc.field name="v" label="Speed" value="100" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:CL,L,rho,v">
            <x-calc.field name="S" label="Wing area" value="16.2" min="0" placeholder="Wing area">
                <label for="calc-S-unit" class="sr-only">Wing area unit</label>
                <select id="calc-S-unit" name="S-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
        <div data-show-when="solve:rho" hidden>
            <x-calc.select name="out_rho" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
        </div>
        <div data-show-when="solve:v" hidden>
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="knot" />
        </div>
        <div data-show-when="solve:S" hidden>
            <x-calc.select name="out_S" label="Show the result in" :options="['m2' => 'm²', 'cm2' => 'cm²', 'mm2' => 'mm²', 'km2' => 'km²', 'ha' => 'ha', 'ft2' => 'ft²', 'in2' => 'in²', 'yd2' => 'yd²', 'acre' => 'ac']" selected="m2" />
        </div>
    </div>

    <x-calc.result label="Lift coefficient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'CL', 'CL' => 0.4, 'L' => 10787, 'L-unit' => 'n', 'out_L' => 'n', 'rho' => 1.225, 'rho-unit' => 'kgm3', 'out_rho' => 'kgm3', 'v' => 100, 'v-unit' => 'knot', 'out_v' => 'knot', 'S' => 16.2, 'S-unit' => 'm2', 'out_S' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'mass' => ['label' => 'Mass that lift supports'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C_L = 2L ÷ (ρ v² S)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
