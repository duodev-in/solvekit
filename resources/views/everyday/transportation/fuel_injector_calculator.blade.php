<x-calc.page
    title="Fuel Injector Calculator - SolveKit"
    description="Free fuel injector calculator: injector size in lb/h and cc/min for a horsepower target from BSFC, number of injectors, duty cycle and fuel pressure."
    lede="Size fuel injectors for a power target."
    about="Injector flow = horsepower × BSFC ÷ (injectors × maximum duty cycle). Typical BSFC is 0.45–0.50 lb/hp·h for naturally aspirated gasoline engines, 0.55–0.65 for boosted ones and about 0.7–0.8 for E85. Flow changes with the square root of fuel pressure, and injectors are rated at a stated pressure (often 43.5 psi, 3 bar). cc/min ≈ lb/h × 10.5 is the usual industry conversion."
    :calc="['engine' => 'ev-transport', 'tool' => 'injector', 'fields' => ['power', 'bsfc', 'cylinders', 'duty', 'rated_pressure', 'pressure'], 'unitFields' => ['power' => collect(config('units.power'))->only(['hp', 'kw', 'ps'])->all(), 'rated_pressure' => collect(config('units.pressure'))->only(['psi', 'bar', 'kpa'])->all(), 'pressure' => collect(config('units.pressure'))->only(['psi', 'bar', 'kpa'])->all()]]"
    :how-to="[
        ['name' => 'Enter the power target', 'text' => 'At the crankshaft.'],
        ['name' => 'Enter BSFC, injectors and duty cycle', 'text' => 'And the fuel pressures.'],
    ]"
    :faqs="[
        ['question' => 'What size injectors for 450 hp?', 'answer' => 'Boosted (BSFC 0.6) on 8 injectors at 80% and 43.5 psi: about 42 lb/h; raising pressure to 58 psi brings it to about 37 lb/h.'],
        ['question' => 'Why limit duty cycle to 80%?', 'answer' => 'To leave headroom; injectors near 100% stop controlling fuel well.'],
        ['question' => 'How do I convert lb/h to cc/min?', 'answer' => 'Multiply by about 10.5.'],
    ]"
>
    <x-calc.field name="power" label="Target crank power" value="450" min="0" placeholder="Target crank power">
        <label for="calc-power-unit" class="sr-only">Target crank power unit</label>
        <select id="calc-power-unit" name="power-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.power'))->only(['hp', 'kw', 'ps']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bsfc" label="BSFC" value="0.6" min="0.3" max="1.2" step="0.01" suffix="lb/hp·h" />
        <x-calc.field name="cylinders" label="Injectors" value="8" min="1" step="1" />
        <x-calc.field name="duty" label="Max duty cycle" value="80" min="10" max="100" step="1" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rated_pressure" label="Injector rated at" value="43.5" min="0" placeholder="Injector rated at">
            <label for="calc-rated_pressure-unit" class="sr-only">Injector rated at unit</label>
            <select id="calc-rated_pressure-unit" name="rated_pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['psi', 'bar', 'kpa']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pressure" label="Your fuel pressure" value="58" min="0" placeholder="Your fuel pressure">
            <label for="calc-pressure-unit" class="sr-only">Your fuel pressure unit</label>
            <select id="calc-pressure-unit" name="pressure-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.pressure'))->only(['psi', 'bar', 'kpa']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'psi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Injector size needed (at the rated pressure)" />

    <x-calc.options :examples="[
        '450 hp turbo V8' => ['power' => 450, 'power-unit' => 'hp', 'bsfc' => 0.6, 'cylinders' => 8, 'duty' => 80, 'rated_pressure' => 43.5, 'rated_pressure-unit' => 'psi', 'pressure' => 58, 'pressure-unit' => 'psi'],
        '300 hp NA four' => ['power' => 300, 'power-unit' => 'hp', 'bsfc' => 0.5, 'cylinders' => 4, 'duty' => 80, 'rated_pressure' => 3, 'rated_pressure-unit' => 'bar', 'pressure' => 3, 'pressure-unit' => 'bar'],
        'E85, 600 hp' => ['power' => 600, 'power-unit' => 'hp', 'bsfc' => 0.8, 'cylinders' => 6, 'duty' => 85, 'rated_pressure' => 43.5, 'rated_pressure-unit' => 'psi', 'pressure' => 43.5, 'pressure-unit' => 'psi'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cc' => ['label' => 'In cc/min'],
            'at' => ['label' => 'At your pressure'],
            'pressure' => ['label' => 'Pressure effect'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lb/h = hp × BSFC ÷ (n × duty)</li>
            <li>flow₂ = flow₁ × √(p₂ ÷ p₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
