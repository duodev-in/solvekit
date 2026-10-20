<x-calc.page
    title="Heat Transfer Calculator - SolveKit"
    description="Free heat transfer calculator: conduction, convection and radiation heat flow."
    lede="Find heat transfer rate."
    about="Heat moves by conduction through solids, convection to fluids and radiation between surfaces. Each has its own law."
    :calc="['engine' => 'ph-thermo', 'tool' => 'heat_transfer', 'fields' => ['mode', 'k', 'L', 'h', 'eps', 'A', 'T1', 'T2', 'out'], 'unitFields' => ['k' => collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f'])->all(), 'A' => collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'T2' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['area', 'energy', 'force', 'heat_transfer_coefficient', 'length', 'mass', 'power', 'speed', 'temperature', 'thermal_conductivity'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What conducts through 10 m² of 100 mm insulation with a 20 K difference?', 'answer' => '80 W.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Mode" :options="['cond' => 'Conduction (Fourier)', 'conv' => 'Convection (Newton)', 'rad' => 'Radiation (Stefan–Boltzmann)']" selected="cond" />
        <div data-show-when="mode:cond">
            <x-calc.field name="k" label="Thermal conductivity" value="0.04" min="0" placeholder="Thermal conductivity">
                <label for="calc-k-unit" class="sr-only">Thermal conductivity unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wmk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:cond">
            <x-calc.field name="L" label="Thickness" value="100" placeholder="Thickness">
                <label for="calc-L-unit" class="sr-only">Thickness unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:conv">
            <x-calc.field name="h" label="Heat transfer coefficient" value="10" min="0" placeholder="Heat transfer coefficient">
                <label for="calc-h-unit" class="sr-only">Heat transfer coefficient unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wm2k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:rad">
            <x-calc.field name="eps" label="Emissivity" value="0.9" min="0" step="any" />
        </div>
        <x-calc.field name="A" label="Area" value="10" min="0" placeholder="Area">
            <label for="calc-A-unit" class="sr-only">Area unit</label>
            <select id="calc-A-unit" name="A-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['m2', 'cm2', 'mm2', 'km2', 'ha', 'ft2', 'in2', 'yd2', 'acre']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T1" label="Hot side or surface temperature" value="20" placeholder="Hot side or surface temperature">
            <label for="calc-T1-unit" class="sr-only">Hot side or surface temperature unit</label>
            <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T2" label="Cold side or surroundings temperature" value="0" placeholder="Cold side or surroundings temperature">
            <label for="calc-T2-unit" class="sr-only">Cold side or surroundings temperature unit</label>
            <select id="calc-T2-unit" name="T2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="w" />
    </div>

    <x-calc.result label="Heat transfer rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'w', 'mode' => 'cond', 'k' => 0.04, 'k-unit' => 'wmk', 'L' => 100, 'L-unit' => 'mm', 'h' => 10, 'h-unit' => 'wm2k', 'eps' => 0.9, 'A' => 10, 'A-unit' => 'm2', 'T1' => 20, 'T1-unit' => 'c', 'T2' => 0, 'T2-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'flux' => ['label' => 'Heat flux'],
            'day' => ['label' => 'Energy per day'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
