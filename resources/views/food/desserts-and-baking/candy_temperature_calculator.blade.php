<x-calc.page
    title="Candy Temperature Calculator - SolveKit"
    description="Free candy temperature calculator: sugar-syrup stages from thread to hard crack, adjusted for your altitude, in °F and °C, with the cold-water test for each."
    lede="Find candy stage temperatures for your altitude."
    about="As syrup boils, water evaporates and the temperature climbs; each stage (soft ball, hard crack …) matches a sugar concentration. Water boils lower at altitude, so every stage is reached at a lower temperature: subtract the difference between 212 °F and your boiling point. Test your thermometer in boiling water on the day for the most accurate offset."
    :calc="['engine' => 'fd-bake', 'tool' => 'candy', 'fields' => ['stage', 'altitude'], 'unitFields' => ['altitude' => collect(config('units.length'))->only(['ft', 'm'])->all()], 'data' => ['candy' => config('food_data.candy')]]"
    :how-to="[
        ['name' => 'Choose the stage', 'text' => ''],
        ['name' => 'Enter your altitude', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is soft ball at 5,000 ft?', 'answer' => '226–231 °F.'],
        ['question' => 'What is hard crack at sea level?', 'answer' => '300–310 °F.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="stage" label="Stage" :options="collect(config('food_data.candy'))->mapWithKeys(fn ($s) => [$s[0] => $s[1]])->all()" selected="soft_ball" />
        <x-calc.field name="altitude" label="Altitude" value="5000" min="0" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Target temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Soft ball, 5,000 ft' => ['stage' => 'soft_ball', 'altitude' => 5000, 'altitude-unit' => 'ft'],
        'Hard crack, sea level' => ['stage' => 'hard_crack', 'altitude' => 0, 'altitude-unit' => 'ft'],
        'Firm ball, 2,000 m' => ['stage' => 'firm_ball', 'altitude' => 2000, 'altitude-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sea' => ['label' => 'At sea level'],
            'test' => ['label' => 'Cold-water test'],
            'uses' => ['label' => 'Used for'],
            'drop' => ['label' => 'Altitude change'],
        ]" />
        <x-calc.grid heading="Stages" name="stages" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>target = sea-level temperature − (212 °F − boiling point)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
