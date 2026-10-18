<x-calc.page
    title="Boost Horsepower Calculator - SolveKit"
    description="Free boost horsepower calculator: ideal power of a turbocharged or supercharged engine from its naturally aspirated power, boost pressure and altitude."
    lede="Estimate how much power boost adds to an engine."
    about="Power rises roughly with the mass of air in the cylinders, which rises with absolute manifold pressure. Ideal boosted power = naturally aspirated power × (atmospheric pressure + boost) ÷ atmospheric pressure. Real gains are lower because compressing air heats it (intercoolers help) and the turbo or supercharger costs some power. Altitude lowers atmospheric pressure (standard atmosphere)."
    :calc="['engine' => 'ev-transport', 'tool' => 'boost_hp', 'fields' => ['power', 'boost', 'altitude'], 'unitFields' => ['power' => collect(config('units.power'))->only(['hp', 'kw', 'ps'])->all(), 'boost' => collect(config('units.pressure'))->only(['psi', 'bar', 'kpa'])->all(), 'altitude' => collect(config('units.length'))->only(['ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the engine\'s power', 'text' => 'As rated at sea level.'],
        ['name' => 'Enter the boost', 'text' => 'Gauge pressure, and your altitude.'],
    ]"
    :faqs="[
        ['question' => 'How much power does 8 psi of boost add?', 'answer' => 'Ideally about 54%: 300 hp becomes about 463 hp at sea level.'],
        ['question' => 'Why is my real gain lower?', 'answer' => 'Heat from compression, lower efficiency and timing changes cut the gain.'],
        ['question' => 'Does boost help at altitude?', 'answer' => 'Yes, a turbo can restore some of the power lost to thin air.'],
    ]"
>
    <x-calc.field name="power" label="Naturally aspirated power (sea level)" value="300" min="0" placeholder="Naturally aspirated power (sea level)">
        <label for="calc-power-unit" class="sr-only">Naturally aspirated power (sea level) unit</label>
        <select id="calc-power-unit" name="power-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.power'))->only(['hp', 'kw', 'ps']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="boost" label="Boost pressure" value="8" min="0" placeholder="Boost pressure">
            <label for="calc-boost-unit" class="sr-only">Boost pressure unit</label>
            <select id="calc-boost-unit" name="boost-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['psi', 'bar', 'kpa']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="altitude" label="Altitude" value="0" min="0" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Boosted horsepower (ideal)" />

    <x-calc.options :examples="[
        '300 hp, 8 psi' => ['power' => 300, 'power-unit' => 'hp', 'boost' => 8, 'boost-unit' => 'psi', 'altitude' => 0, 'altitude-unit' => 'ft'],
        '150 kW, 1 bar' => ['power' => 150, 'power-unit' => 'kw', 'boost' => 1, 'boost-unit' => 'bar', 'altitude' => 0, 'altitude-unit' => 'm'],
        'At 5,000 ft' => ['power' => 300, 'power-unit' => 'hp', 'boost' => 10, 'boost-unit' => 'psi', 'altitude' => 5000, 'altitude-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kw' => ['label' => 'In kW'],
            'gain' => ['label' => 'Gain'],
            'ratio' => ['label' => 'Pressure ratio'],
            'natural' => ['label' => 'Without boost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hp boosted = hp NA × (p atm + boost) ÷ p atm</li>
            <li>p atm = 101.325 × (1 − 2.25577×10⁻⁵ h)^5.25588 kPa</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
