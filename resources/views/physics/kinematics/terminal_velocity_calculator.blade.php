<x-calc.page
    title="Terminal Velocity Calculator - SolveKit"
    description="Free terminal velocity calculator: the top falling speed from mass, drag coefficient, area and air density."
    lede="Find terminal velocity."
    about="A falling body speeds up until drag ½ρC_dAv² equals its weight. That speed is v = √(2mg ÷ ρC_dA). A skydiver belly-down reaches roughly 55 m/s (200 km/h); head-down, much faster."
    :calc="['engine' => 'ph-mech', 'tool' => 'terminal_velocity', 'fields' => ['solve', 'v', 'm', 'g', 'rho', 'cd', 'A', 'out_v', 'out_m', 'out_g', 'out_rho', 'out_A'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'area', 'density', 'energy', 'force', 'length', 'mass', 'speed', 'time', 'v'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the terminal velocity of a 75 kg skydiver (C_dA = 0.42 m²)?', 'answer' => '53.4704 m/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['v' => 'Terminal velocity', 'm' => 'Mass', 'g' => 'Gravity', 'rho' => 'Fluid density', 'cd' => 'Drag coefficient', 'A' => 'Frontal area']" selected="v" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:m,g,rho,cd,A" hidden>
            <x-calc.field name="v" label="Terminal velocity" value="53.5" placeholder="Terminal velocity">
                <label for="calc-v-unit" class="sr-only">Terminal velocity unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,g,rho,cd,A">
            <x-calc.field name="m" label="Mass" value="75" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,m,rho,cd,A">
            <x-calc.field name="g" label="Gravity" value="9.80665" placeholder="Gravity">
                <label for="calc-g-unit" class="sr-only">Gravity unit</label>
                <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,m,g,cd,A">
            <x-calc.field name="rho" label="Fluid density" value="1.225" min="0" placeholder="Fluid density">
                <label for="calc-rho-unit" class="sr-only">Fluid density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,m,g,rho,A">
            <x-calc.field name="cd" label="Drag coefficient" value="1" step="any" />
        </div>
        <div data-show-when="solve:v,m,g,rho,cd">
            <x-calc.field name="A" label="Frontal area" value="0.42" min="0" placeholder="Frontal area">
                <label for="calc-A-unit" class="sr-only">Frontal area unit</label>
                <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v">
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
        <div data-show-when="solve:g" hidden>
            <x-calc.select name="out_g" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
        </div>
        <div data-show-when="solve:rho" hidden>
            <x-calc.select name="out_rho" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
        </div>
        <div data-show-when="solve:A" hidden>
            <x-calc.select name="out_A" label="Show the result in" :options="['m2' => 'm²', 'cm2' => 'cm²', 'mm2' => 'mm²', 'km2' => 'km²', 'ha' => 'ha', 'ft2' => 'ft²', 'in2' => 'in²', 'yd2' => 'yd²', 'acre' => 'ac']" selected="m2" />
        </div>
    </div>

    <x-calc.result label="Terminal velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'v', 'v' => 53.5, 'v-unit' => 'ms', 'out_v' => 'ms', 'm' => 75, 'm-unit' => 'kg', 'out_m' => 'kg', 'g' => 9.80665, 'g-unit' => 'ms2', 'out_g' => 'ms2', 'rho' => 1.225, 'rho-unit' => 'kgm3', 'out_rho' => 'kgm3', 'cd' => 1, 'A' => 0.42, 'A-unit' => 'm2', 'out_A' => 'm2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            't95' => ['label' => 'Time to reach 95% of it'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>v = √(2mg ÷ ρC_dA)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
