<x-calc.page
    title="Air Fryer Calculator - SolveKit"
    description="Free air fryer calculator: convert an oven recipe to air fryer temperature and time (about 25 °F lower and 20% shorter), with when to shake and when to start checking."
    lede="Convert oven temperature and time for an air fryer."
    about="An air fryer is a small convection oven: the fan moves hot air faster, so food browns and cooks sooner. The usual conversion is 25 °F (about 15 °C) lower and 20% less time than a conventional oven recipe. Results vary by model, basket load and food thickness, so shake or turn the food halfway and start checking a few minutes early. Most air fryers top out at 400 °F (200 °C). Times are guides: check doneness with a food thermometer."
    :calc="['engine' => 'fd-convert', 'tool' => 'air_fryer', 'fields' => ['temp', 'time', 'drop', 'cut'], 'unitFields' => ['temp' => collect(config('units.temperature'))->only(['f', 'c'])->all()]]"
    :how-to="[
        ['name' => 'Enter the oven temperature and time', 'text' => 'From the recipe or package.'],
        ['name' => 'Adjust the rule if you like', 'text' => 'Defaults: 25 °F lower, 20% shorter.'],
    ]"
    :faqs="[
        ['question' => 'What is 400 °F for 20 minutes in an air fryer?', 'answer' => '375 °F, 191 °C for about 16 minutes.'],
        ['question' => 'And a 350 °F, 45-minute bake?', 'answer' => '325 °F, 163 °C for about 36 minutes.'],
        ['question' => 'Why lower the temperature?', 'answer' => 'The fan makes the heat more intense, so the outside browns before the inside cooks at the oven setting.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="temp" label="Oven temperature" value="400" placeholder="Oven temperature">
            <label for="calc-temp-unit" class="sr-only">Oven temperature unit</label>
            <select id="calc-temp-unit" name="temp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="time" label="Oven time" value="20" min="0" step="any" suffix="min" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="drop" label="Lower the temperature by" value="25" min="0" step="any" suffix="°F" />
        <x-calc.field name="cut" label="Shorten the time by" value="20" min="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Air fryer temperature" />

    <x-calc.options :decimals="false" :examples="[
        'Fries' => ['temp' => 400, 'temp-unit' => 'f', 'time' => 20, 'drop' => 25, 'cut' => 20],
        'Baked' => ['temp' => 350, 'temp-unit' => 'f', 'time' => 45, 'drop' => 25, 'cut' => 20],
        'Celsius recipe' => ['temp' => 200, 'temp-unit' => 'c', 'time' => 30, 'drop' => 25, 'cut' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'c' => ['label' => 'In Celsius'],
            'time' => ['label' => 'Cooking time'],
            'flip' => ['label' => 'Shake or turn'],
            'check' => ['label' => 'Check from'],
            'limit' => ['label' => 'Air fryer limit'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>air fryer °F = oven °F − 25</li>
            <li>time = oven time × (1 − 20%)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
