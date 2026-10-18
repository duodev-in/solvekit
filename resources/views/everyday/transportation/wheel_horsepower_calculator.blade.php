<x-calc.page
    title="Wheel Horsepower Calculator - SolveKit"
    description="Free wheel horsepower calculator: wheel horsepower from crank horsepower, or crank from a dyno's wheel figure, using a drivetrain loss percentage."
    lede="Convert between crank and wheel horsepower."
    about="Wheel horsepower = crank horsepower × (1 − drivetrain loss). Common rules of thumb are about 10–15% for manual front- and rear-wheel-drive cars, 15–20% for automatics and 20–25% for all-wheel drive, but real losses vary by car and dyno type. Treat the result as an estimate."
    :calc="['engine' => 'ev-transport', 'tool' => 'wheel_hp', 'fields' => ['direction', 'power', 'loss'], 'unitFields' => ['power' => collect(config('units.power'))->only(['hp', 'kw', 'ps'])->all()]]"
    :how-to="[
        ['name' => 'Choose the direction', 'text' => 'Crank to wheel or back.'],
        ['name' => 'Enter the loss', 'text' => 'About 15% is a common guess.'],
    ]"
    :faqs="[
        ['question' => 'How much power is lost to the wheels?', 'answer' => 'Often 10–25% depending on drivetrain.'],
        ['question' => 'What is 400 crank hp at the wheels?', 'answer' => '340 whp at 15% loss.'],
        ['question' => 'How do I estimate crank hp from a dyno?', 'answer' => 'Divide wheel hp by (1 − loss): 300 whp at 15% ≈ 353 hp.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['to_wheel' => 'Crank → wheel', 'to_crank' => 'Wheel → crank']" selected="to_wheel" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="power" label="Horsepower" value="400" min="0" placeholder="Horsepower">
            <label for="calc-power-unit" class="sr-only">Horsepower unit</label>
            <select id="calc-power-unit" name="power-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.power'))->only(['hp', 'kw', 'ps']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hp')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="loss" label="Drivetrain loss" value="15" min="0" max="60" step="1" suffix="%" />
    </div>

    <x-calc.result label="Wheel horsepower" />

    <x-calc.options :examples="[
        '400 hp, 15%' => ['direction' => 'to_wheel', 'power' => 400, 'power-unit' => 'hp', 'loss' => 15],
        '300 whp, AWD 20%' => ['direction' => 'to_crank', 'power' => 300, 'power-unit' => 'hp', 'loss' => 20],
        '150 kW, 12%' => ['direction' => 'to_wheel', 'power' => 150, 'power-unit' => 'kw', 'loss' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kw' => ['label' => 'In kW'],
            'lost' => ['label' => 'Lost'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>whp = hp × (1 − loss)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
