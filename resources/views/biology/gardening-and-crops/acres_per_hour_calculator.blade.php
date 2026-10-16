<x-calc.page
    title="Acres Per Hour Calculator - SolveKit"
    description="Free acres per hour calculator: field capacity of a tractor implement from width, speed and efficiency."
    lede="Work out how many acres an implement covers per hour."
    about="Theoretical capacity is width × speed. Field efficiency (usually 65 to 90%) allows for turning, overlap and refilling. In US units, acres per hour = width (ft) × speed (mph) × efficiency ÷ 8.25."
    :calc="['engine' => 'garden', 'tool' => 'acres_per_hour', 'fields' => ['width', 'speed', 'efficiency', 'field'], 'unitFields' => ['width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'speed' => collect(config('units.speed'))->only(['mph', 'kmh'])->all(), 'field' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Enter the implement', 'text' => 'Working width and travel speed.'],
        ['name' => 'Enter efficiency', 'text' => 'Use 80% if unsure; lower for small or odd-shaped fields.'],
    ]"
    :faqs="[
        ['question' => 'What is field efficiency?', 'answer' => 'The share of time spent actually working, after turns, overlap and stops.'],
        ['question' => 'Where does 8.25 come from?', 'answer' => 'It converts ft × mph to acres per hour: 43,560 ÷ 5,280.'],
        ['question' => 'What efficiency do planters have?', 'answer' => 'Typically 50 to 75%; tillage tools often 70 to 90%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="width" label="Working width" value="30" min="0" placeholder="Working width">
            <label for="calc-width-unit" class="sr-only">Working width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="speed" label="Speed" value="5" min="0" placeholder="Speed">
            <label for="calc-speed-unit" class="sr-only">Speed unit</label>
            <select id="calc-speed-unit" name="speed-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['mph', 'kmh']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mph')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="efficiency" label="Field efficiency" value="80" min="1" max="100" suffix="%" />
    </div>

    <x-calc.field name="field" label="Field size (optional)" value="160" min="0" placeholder="Field size (optional)">
        <label for="calc-field-unit" class="sr-only">Field size (optional) unit</label>
        <select id="calc-field-unit" name="field-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'acre')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Field capacity" />

    <x-calc.options :examples="[
        'Planter 30 ft at 5 mph' => ['width' => 30, 'speed' => 5, 'efficiency' => 65],
        'Sprayer 90 ft at 10 mph' => ['width' => 90, 'speed' => 10, 'efficiency' => 65],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hectares' => ['label' => 'Hectares per hour', 'unit' => 'ha/h'],
            'theoretical' => ['label' => 'At 100% efficiency', 'unit' => 'ac/h'],
            'field' => ['label' => 'Time for the field'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ac/h = width (ft) × mph × efficiency ÷ 8.25</li>
            <li>ha/h = width (m) × km/h × efficiency ÷ 10</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
