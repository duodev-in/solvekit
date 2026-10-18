<x-calc.page
    title="Wind Turbine Calculator - SolveKit"
    description="Free wind turbine calculator: power from rotor size and wind speed, P = ½ ρ A v³ Cp, the Betz limit, and yearly energy from an average wind speed."
    lede="Work out a wind turbine's power and yearly energy."
    about="Wind power P = ½ × air density × swept area × v³ × power coefficient. No turbine can capture more than 16/27 (59.3%) of the wind's energy (the Betz limit); good large turbines reach about 0.45. Yearly energy uses a Rayleigh distribution of wind speeds around your average, with the turbine's cut-in, rated and cut-out limits (a standard model; real sites differ)."
    :calc="['engine' => 'eco-energy', 'tool' => 'wind', 'fields' => ['mode', 'diameter', 'cp', 'speed', 'mean', 'rated', 'cut_in', 'cut_out', 'altitude', 'temperature'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'altitude' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'temperature' => collect(config('units.temperature'))->only(['c', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Enter the rotor size and Cp', 'text' => 'Diameter of the blades\' circle.'],
        ['name' => 'Enter the wind speed', 'text' => 'Or the yearly average for energy.'],
    ]"
    :faqs="[
        ['question' => 'How much power is in 10 m/s wind?', 'answer' => 'About 610 W per m² of rotor at sea level.'],
        ['question' => 'Why does wind speed matter so much?', 'answer' => 'Power rises with the cube of speed: twice the wind gives eight times the power.'],
        ['question' => 'What is the Betz limit?', 'answer' => '16/27, the most energy any turbine can extract from the wind.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['speed' => 'Power at a wind speed', 'average' => 'Yearly energy']" selected="speed" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="diameter" label="Rotor diameter" value="10" min="0" placeholder="Rotor diameter">
            <label for="calc-diameter-unit" class="sr-only">Rotor diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="cp" label="Power coefficient Cp" value="0.4" min="0.01" max="0.593" step="0.01" />
    </div>

    <div data-show-when="mode:speed">
        <x-calc.field name="speed" label="Wind speed" value="8" min="0" step="0.1" suffix="m/s" />
    </div>

    <div data-show-when="mode:average" hidden>
        <x-calc.field name="mean" label="Average wind speed" value="6" min="0.1" step="0.1" suffix="m/s" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rated" label="Rated power (optional)" value="20" min="0" suffix="kW" />
        <x-calc.field name="cut_in" label="Cut-in speed" value="3" min="0" step="0.5" suffix="m/s" />
        <x-calc.field name="cut_out" label="Cut-out speed" value="25" min="0" step="0.5" suffix="m/s" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="altitude" label="Altitude" value="0" min="0" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="temperature" label="Air temperature" value="15" placeholder="Air temperature">
            <label for="calc-temperature-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Turbine power" />

    <x-calc.options :examples="[
        '10 m rotor at 8 m/s' => ['mode' => 'speed', 'diameter' => 10, 'diameter-unit' => 'm', 'cp' => 0.4, 'speed' => 8, 'rated' => 20, 'cut_in' => 3, 'cut_out' => 25, 'altitude' => 0, 'altitude-unit' => 'm', 'temperature' => 15, 'temperature-unit' => 'c'],
        'Small turbine, 5 m/s average' => ['mode' => 'average', 'diameter' => 3.7, 'diameter-unit' => 'm', 'cp' => 0.35, 'mean' => 5, 'rated' => 2.4, 'cut_in' => 3, 'cut_out' => 25, 'altitude' => 300, 'altitude-unit' => 'm', 'temperature' => 10, 'temperature-unit' => 'c'],
        'Utility 120 m, 7.5 m/s average' => ['mode' => 'average', 'diameter' => 120, 'diameter-unit' => 'm', 'cp' => 0.45, 'mean' => 7.5, 'rated' => 3600, 'cut_in' => 3, 'cut_out' => 25, 'altitude' => 0, 'altitude-unit' => 'm', 'temperature' => 15, 'temperature-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Power curve" name="curve" />
        <div data-show-when="mode:speed">
            <x-calc.rows heading="Details" :rows="[
                'wind' => ['label' => 'Power in the wind'],
                'betz' => ['label' => 'Betz limit'],
                'area' => ['label' => 'Swept area'],
                'density' => ['label' => 'Air density'],
            ]" />
        </div>
        <div data-show-when="mode:average" hidden>
            <x-calc.rows heading="Details" :rows="[
                'average' => ['label' => 'Average output'],
                'capacity' => ['label' => 'Capacity factor'],
                'area' => ['label' => 'Swept area'],
                'density' => ['label' => 'Air density'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = ½ ρ A v³ Cp, Cp ≤ 16/27</li>
            <li>Rayleigh: f(v) = (π v ÷ 2 v̄²) e^(−π v² ÷ 4 v̄²)</li>
            <li>ρ = p ÷ (287.05 T)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
