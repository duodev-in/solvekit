<x-calc.page
    title="Windsurfing Calculator - SolveKit"
    description="Free windsurfing calculator: sail size for your weight and the wind."
    lede="Find your sail size."
    about="Sail size scales with sailor weight and falls as the wind rises."
    :calc="['engine' => 'sp-misc', 'tool' => 'windsurf', 'fields' => ['w', 'wind', 'skill'], 'unitFields' => ['w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'wind' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What sail for 75 kg in 15 knots?', 'answer' => 'About 6.7 m².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Sailor weight" value="75" min="0" placeholder="Sailor weight">
            <label for="calc-w-unit" class="sr-only">Sailor weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="wind" label="Wind speed" value="15" placeholder="Wind speed">
            <label for="calc-wind-unit" class="sr-only">Wind speed unit</label>
            <select id="calc-wind-unit" name="wind-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="skill" label="Skill" :options="['1.34' => 'Intermediate (planing)', '1.5' => 'Beginner or light wind', '1.2' => 'Advanced']" selected="1.34" />
    </div>

    <x-calc.result label="Sail size" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 75, 'w-unit' => 'kg', 'wind' => 15, 'wind-unit' => 'knot', 'skill' => '1.34'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'board' => ['label' => 'Board volume guide'],
            'range' => ['label' => 'Wind range'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
