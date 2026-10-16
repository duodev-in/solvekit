<x-calc.page
    title="GDU Calculator - SolveKit"
    description="Free GDU calculator: growing degree units for corn from daily high and low temperatures."
    lede="Work out growing degree units (GDUs) for corn from the day's high and low."
    about="Corn grows little below 50 °F or faster above 86 °F, so the day's high is capped at 86 °F and both temperatures are raised to at least 50 °F. GDUs are the average of the two minus 50."
    :calc="['engine' => 'garden', 'tool' => 'gdu', 'fields' => ['max', 'min', 'days'], 'unitFields' => ['max' => collect(config('units.temperature'))->only(['c', 'f'])->all(), 'min' => collect(config('units.temperature'))->only(['c', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Enter the high and low', 'text' => 'From a weather station near the field.'],
        ['name' => 'Add days (optional)', 'text' => 'For a rough total over a stretch of similar weather.'],
    ]"
    :faqs="[
        ['question' => 'How many GDUs does corn need?', 'answer' => 'Most hybrids need about 2,400 to 2,800 GDUs to maturity; check the seed bag.'],
        ['question' => 'Why cap at 86 °F?', 'answer' => 'Corn development does not speed up above about 86 °F.'],
        ['question' => 'What is the base temperature?', 'answer' => '50 °F (10 °C) for corn.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="max" label="High" value="84" placeholder="High">
            <label for="calc-max-unit" class="sr-only">High unit</label>
            <select id="calc-max-unit" name="max-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="min" label="Low" value="62" placeholder="Low">
            <label for="calc-min-unit" class="sr-only">Low unit</label>
            <select id="calc-min-unit" name="min-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="days" label="Similar days (optional)" value="30" min="0" step="1" />

    <x-calc.result label="Growing degree units today" />

    <x-calc.options :examples="[
        'Warm day 88/66 °F' => ['max' => 88, 'min' => 66],
        'Cool day 68/45 °F' => ['max' => 68, 'min' => 45],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'celsius' => ['label' => 'Celsius basis', 'unit' => '°C·d'],
            'high' => ['label' => 'High used'],
            'low' => ['label' => 'Low used'],
            'season' => ['label' => 'Over several days'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GDU = (max + min) ÷ 2 − 50</li>
            <li>max capped at 86 °F; max and min raised to 50 °F</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
