<x-calc.page
    title="Bernoulli Equation Calculator - SolveKit"
    description="Free Bernoulli equation calculator: pressure, speed or height at two points of a flow, solved for any value."
    lede="Solve the Bernoulli equation."
    about="Along a streamline of steady, frictionless, incompressible flow, pressure plus kinetic energy plus potential energy per volume stays constant. Faster flow means lower pressure."
    :calc="['engine' => 'ph-fluid', 'tool' => 'bernoulli', 'fields' => ['solve', 'P1', 'v1', 'h1', 'P2', 'v2', 'h2', 'rho', 'out_P1', 'out_v1', 'out_h1', 'out_P2', 'out_v2', 'out_h2', 'out_rho'], 'unitFields' => ['P1' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'v1' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'h1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'P2' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'v2' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'h2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the pressure where water speeds up from 2 to 6 m/s at 200 kPa?', 'answer' => '184 kPa.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['P1' => 'Pressure at point 1', 'v1' => 'Speed at point 1', 'h1' => 'Height of point 1', 'P2' => 'Pressure at point 2', 'v2' => 'Speed at point 2', 'h2' => 'Height of point 2', 'rho' => 'Density']" selected="P2" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:v1,h1,P2,v2,h2,rho">
            <x-calc.field name="P1" label="Pressure at point 1" value="200" min="0" placeholder="Pressure at point 1">
                <label for="calc-P1-unit" class="sr-only">Pressure at point 1 unit</label>
                <select id="calc-P1-unit" name="P1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,h1,P2,v2,h2,rho">
            <x-calc.field name="v1" label="Speed at point 1" value="2" placeholder="Speed at point 1">
                <label for="calc-v1-unit" class="sr-only">Speed at point 1 unit</label>
                <select id="calc-v1-unit" name="v1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,v1,P2,v2,h2,rho">
            <x-calc.field name="h1" label="Height of point 1" value="0" placeholder="Height of point 1">
                <label for="calc-h1-unit" class="sr-only">Height of point 1 unit</label>
                <select id="calc-h1-unit" name="h1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,v1,h1,v2,h2,rho" hidden>
            <x-calc.field name="P2" label="Pressure at point 2" value="183" min="0" placeholder="Pressure at point 2">
                <label for="calc-P2-unit" class="sr-only">Pressure at point 2 unit</label>
                <select id="calc-P2-unit" name="P2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,v1,h1,P2,h2,rho">
            <x-calc.field name="v2" label="Speed at point 2" value="6" placeholder="Speed at point 2">
                <label for="calc-v2-unit" class="sr-only">Speed at point 2 unit</label>
                <select id="calc-v2-unit" name="v2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,v1,h1,P2,v2,rho">
            <x-calc.field name="h2" label="Height of point 2" value="0" placeholder="Height of point 2">
                <label for="calc-h2-unit" class="sr-only">Height of point 2 unit</label>
                <select id="calc-h2-unit" name="h2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1,v1,h1,P2,v2,h2">
            <x-calc.field name="rho" label="Density" value="1000" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:P1" hidden>
            <x-calc.select name="out_P1" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
        </div>
        <div data-show-when="solve:v1" hidden>
            <x-calc.select name="out_v1" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:h1" hidden>
            <x-calc.select name="out_h1" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:P2">
            <x-calc.select name="out_P2" label="Show the result in" :options="['pa' => 'Pa', 'kpa' => 'kPa', 'mpa' => 'MPa', 'gpa' => 'GPa', 'hpa' => 'hPa', 'bar' => 'bar', 'mbar' => 'mbar', 'atm' => 'atm', 'psi' => 'psi', 'ksi' => 'ksi', 'torr' => 'Torr', 'mmhg' => 'mmHg', 'inhg' => 'inHg', 'inh2o' => 'inH₂O']" selected="kpa" />
        </div>
        <div data-show-when="solve:v2" hidden>
            <x-calc.select name="out_v2" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:h2" hidden>
            <x-calc.select name="out_h2" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:rho" hidden>
            <x-calc.select name="out_rho" label="Show the result in" :options="['kgm3' => 'kg/m³', 'gcm3' => 'g/cm³', 'lbft3' => 'lb/ft³', 'lbin3' => 'lb/in³', 'lbgal' => 'lb/gal']" selected="kgm3" />
        </div>
    </div>

    <x-calc.result label="Pressure at point 2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'P2', 'P1' => 200, 'P1-unit' => 'kpa', 'out_P1' => 'kpa', 'v1' => 2, 'v1-unit' => 'ms', 'out_v1' => 'ms', 'h1' => 0, 'h1-unit' => 'm', 'out_h1' => 'm', 'P2' => 183, 'P2-unit' => 'kpa', 'out_P2' => 'kpa', 'v2' => 6, 'v2-unit' => 'ms', 'out_v2' => 'ms', 'h2' => 0, 'h2-unit' => 'm', 'out_h2' => 'm', 'rho' => 1000, 'rho-unit' => 'kgm3', 'out_rho' => 'kgm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'head' => ['label' => 'Total head'],
            'dyn' => ['label' => 'Dynamic pressure at point 2'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P₁ + ½ρv₁² + ρgh₁ = P₂ + ½ρv₂² + ρgh₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
