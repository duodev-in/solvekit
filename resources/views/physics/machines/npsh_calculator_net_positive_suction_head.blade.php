<x-calc.page
    title="NPSH Calculator – Net Positive Suction Head - SolveKit"
    description="Free NPSH calculator: net positive suction head available for a pump, with water vapour pressure from IAPWS-IF97."
    lede="Find NPSH available."
    about="A pump cavitates if the pressure at its inlet drops near the liquid’s vapour pressure. NPSH available is the head left above vapour pressure; it must exceed the pump’s NPSH required with a margin. Hot water and suction lifts reduce it."
    :calc="['engine' => 'ph-mach', 'tool' => 'npsh', 'fields' => ['liquid', 'T', 'Ps', 'z', 'hf', 'pv', 'rho', 'req', 'out'], 'unitFields' => ['T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Ps' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'z' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'hf' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'pv' => collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o'])->all(), 'rho' => collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal'])->all(), 'req' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['density', 'energy', 'force', 'length', 'mass', 'pressure', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is NPSHa for 20 °C water with a 3 m suction lift?', 'answer' => '6.6119 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="liquid" label="Liquid" :options="['water' => 'Water (IAPWS-IF97)', 'custom' => 'Other liquid']" selected="water" />
        <div data-show-when="liquid:water">
            <x-calc.field name="T" label="Liquid temperature" value="20" placeholder="Liquid temperature">
                <label for="calc-T-unit" class="sr-only">Liquid temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="Ps" label="Pressure on the liquid surface (absolute)" value="101.325" min="0" placeholder="Pressure on the liquid surface (absolute)">
            <label for="calc-Ps-unit" class="sr-only">Pressure on the liquid surface (absolute) unit</label>
            <select id="calc-Ps-unit" name="Ps-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="z" label="Liquid level above the pump inlet (negative for a suction lift)" value="-3" placeholder="Liquid level above the pump inlet (negative for a suction lift)">
            <label for="calc-z-unit" class="sr-only">Liquid level above the pump inlet (negative for a suction lift) unit</label>
            <select id="calc-z-unit" name="z-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="hf" label="Suction line losses" value="0.5" placeholder="Suction line losses">
            <label for="calc-hf-unit" class="sr-only">Suction line losses unit</label>
            <select id="calc-hf-unit" name="hf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="liquid:custom">
            <x-calc.field name="pv" label="Vapour pressure" value="3" min="0" placeholder="Vapour pressure">
                <label for="calc-pv-unit" class="sr-only">Vapour pressure unit</label>
                <select id="calc-pv-unit" name="pv-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.pressure'))->only(['pa', 'kpa', 'mpa', 'gpa', 'hpa', 'bar', 'mbar', 'atm', 'psi', 'ksi', 'torr', 'mmhg', 'inhg', 'inh2o']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kpa')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="liquid:custom">
            <x-calc.field name="rho" label="Density" value="1000" min="0" placeholder="Density">
                <label for="calc-rho-unit" class="sr-only">Density unit</label>
                <select id="calc-rho-unit" name="rho-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.density'))->only(['kgm3', 'gcm3', 'lbft3', 'lbin3', 'lbgal']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kgm3')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="req" label="NPSH required by the pump (optional)" value="3" placeholder="NPSH required by the pump (optional)">
            <label for="calc-req-unit" class="sr-only">NPSH required by the pump (optional) unit</label>
            <select id="calc-req-unit" name="req-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="NPSH available" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'liquid' => 'water', 'T' => 20, 'T-unit' => 'c', 'Ps' => 101.325, 'Ps-unit' => 'kpa', 'z' => -3, 'z-unit' => 'm', 'hf' => 0.5, 'hf-unit' => 'm', 'pv' => 3, 'pv-unit' => 'kpa', 'rho' => 1000, 'rho-unit' => 'kgm3', 'req' => 3, 'req-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pv' => ['label' => 'Vapour pressure'],
            'head' => ['label' => 'Pressure head (Pₛ − Pᵥ) ÷ ρg'],
            'margin' => ['label' => 'Margin over NPSH required'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
