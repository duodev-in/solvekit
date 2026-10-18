<x-calc.page
    title="Tesla Charging Cost Calculator - SolveKit"
    description="Free Tesla charging cost calculator: cost to drive and charge each Tesla model from its EPA electricity use, with the cost of a full charge and a gas car comparison."
    lede="Work out what it costs to charge and drive a Tesla."
    about="Energy = miles ÷ 100 × the model's EPA rating in kWh per 100 miles (2025–2027 models, fueleconomy.gov). EPA measures energy at the wall, so charging losses are already included; add extra loss only for cold weather or a slow outlet. A full charge is the energy for the EPA range. Supercharger prices vary by site and time."
    :calc="['engine' => 'ev-transport', 'tool' => 'tesla', 'fields' => ['model', 'distance', 'price', 'loss', 'mpg', 'gas_price'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()], 'data' => ['tesla' => config('everyday_data.tesla')]]"
    :how-to="[
        ['name' => 'Choose the model', 'text' => 'With its EPA rating.'],
        ['name' => 'Enter distance and price', 'text' => 'Your home or Supercharger price.'],
    ]"
    :faqs="[
        ['question' => 'How much does it cost to charge a Tesla Model Y?', 'answer' => 'About $0.047 a mile at 17¢/kWh for a 2026 Long Range AWD (27.5 kWh/100 mi).'],
        ['question' => 'Are charging losses included?', 'answer' => 'Yes, EPA ratings are measured at the wall.'],
        ['question' => 'How much is a full charge?', 'answer' => 'About $15 at 17¢/kWh for a Model Y Long Range.'],
    ]"
>
    <x-calc.select name="model" label="Model" :options="collect(config('everyday_data.tesla'))->mapWithKeys(fn ($t) => [$t[0] => $t[1].' ('.$t[2].' kWh/100 mi)'])->all()" selected="2026_model_y_long_range_awd" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="distance" label="Distance" value="1000" min="0" placeholder="Distance">
            <label for="calc-distance-unit" class="sr-only">Distance unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Electricity price" value="0.17" min="0" step="0.01" suffix="$/kWh" />
        <x-calc.field name="loss" label="Extra loss (optional)" value="0" min="0" max="50" step="1" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mpg" label="Gas car to compare" value="30" min="0" step="1" suffix="mpg" />
        <x-calc.field name="gas_price" label="Gas price" value="3.5" min="0" step="0.01" suffix="$/gal" />
    </div>

    <x-calc.result label="Cost to drive" />

    <x-calc.options :examples="[
        'Model Y, 1,000 mi' => ['model' => '2026_model_y_long_range_awd', 'distance' => 1000, 'distance-unit' => 'mi', 'price' => 0.17, 'loss' => 0, 'mpg' => 30, 'gas_price' => 3.5],
        'Model 3, 12,000 mi' => ['model' => '2026_model_3_premium_rwd', 'distance' => 12000, 'distance-unit' => 'mi', 'price' => 0.15, 'loss' => 0, 'mpg' => 32, 'gas_price' => 3.4],
        'Cybertruck, Supercharger' => ['model' => '2026_cybertruck_awd', 'distance' => 500, 'distance-unit' => 'km', 'price' => 0.45, 'loss' => 0, 'mpg' => 20, 'gas_price' => 3.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mile' => ['label' => 'Per mile'],
            'full' => ['label' => 'Full charge'],
            'gas' => ['label' => 'Gas car'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kWh = miles ÷ 100 × kWh/100 mi</li>
            <li>cost = kWh × price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
