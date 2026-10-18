<x-calc.page
    title="Crosswind Calculator - SolveKit"
    description="Free crosswind calculator: crosswind and headwind or tailwind components for a runway from the wind direction and speed, including gusts."
    lede="Work out the crosswind and headwind on a runway."
    about="Crosswind = wind speed × sin(angle between wind and runway); headwind = wind speed × cos(angle). Runway numbers are the magnetic heading ÷ 10 (runway 27 = 270°), so use the magnetic wind direction given by ATIS or the tower. A quick rule: at 15°, a quarter of the wind is crosswind; 30°, half; 45°, three-quarters; 60° or more, nearly all."
    :calc="['engine' => 'ev-transport', 'tool' => 'crosswind', 'fields' => ['runway_mode', 'runway', 'direction', 'speed', 'gust'], 'unitFields' => ['speed' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all(), 'gust' => collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms'])->all()]]"
    :how-to="[
        ['name' => 'Enter the runway', 'text' => 'Its number or exact heading.'],
        ['name' => 'Enter the wind', 'text' => 'Direction it blows from, speed and gusts.'],
    ]"
    :faqs="[
        ['question' => 'What is the crosswind on runway 27 with wind 300 at 18 knots?', 'answer' => '9 knots from the right, with 15.6 knots of headwind.'],
        ['question' => 'What is a typical crosswind limit?', 'answer' => 'Light aircraft often show a demonstrated crosswind of 12–17 knots.'],
        ['question' => 'What does a negative headwind mean?', 'answer' => 'A tailwind.'],
    ]"
>
    <x-calc.segmented name="runway_mode" legend="Runway as" :options="['number' => 'Runway number', 'heading' => 'Heading']" selected="number" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="runway" label="Runway (number or °)" value="27" min="0" max="360" step="1" />
        <x-calc.field name="direction" label="Wind from" value="300" min="0" max="360" step="1" suffix="°" />
        <x-calc.field name="speed" label="Wind speed" value="18" min="0" placeholder="Wind speed">
            <label for="calc-speed-unit" class="sr-only">Wind speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="gust" label="Gusting to (optional)" value="26" min="0" placeholder="Gusting to (optional)">
        <label for="calc-gust-unit" class="sr-only">Gusting to (optional) unit</label>
        <select id="calc-gust-unit" name="gust-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.speed'))->only(['mph', 'kmh', 'knot', 'ms']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Crosswind" />

    <x-calc.options :examples="[
        'Runway 27, wind 300/18G26' => ['runway_mode' => 'number', 'runway' => 27, 'direction' => 300, 'speed' => 18, 'speed-unit' => 'knot', 'gust' => 26, 'gust-unit' => 'knot'],
        'Runway 09, wind 180/12' => ['runway_mode' => 'number', 'runway' => 9, 'direction' => 180, 'speed' => 12, 'speed-unit' => 'knot', 'gust' => '', 'gust-unit' => 'knot'],
        'Heading 045°, wind 020/20' => ['runway_mode' => 'heading', 'runway' => 45, 'direction' => 20, 'speed' => 20, 'speed-unit' => 'knot', 'gust' => '', 'gust-unit' => 'knot'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'head' => ['label' => 'Headwind or tailwind'],
            'gust' => ['label' => 'In gusts'],
            'angle' => ['label' => 'Wind angle'],
            'rule' => ['label' => 'Rule of thumb'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>crosswind = V × sin θ</li>
            <li>headwind = V × cos θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
