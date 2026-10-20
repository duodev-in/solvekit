<x-calc.page
    title="Bike Pace Calculator - SolveKit"
    description="Free bike pace calculator: speed, pace, time or distance for a ride."
    lede="Find cycling speed or time."
    about="Average speed is distance divided by time; pace is the time per kilometre."
    :calc="['engine' => 'sp-cycle', 'tool' => 'bike_pace', 'fields' => ['want', 'd', 't', 'v'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 40 km in 1:20:00?', 'answer' => '30 km/h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="want" label="Find" :options="['speed' => 'Speed and pace', 'time' => 'Time', 'dist' => 'Distance']" selected="speed" />
        <div data-show-when="want:speed,time">
            <x-calc.field name="d" label="Distance" value="40" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="want:speed,dist">
            <x-calc.field name="t" label="Time (h:mm:ss)" value="1:20:00" type="text" inputmode="text" />
        </div>
        <div data-show-when="want:time,dist">
            <x-calc.field name="v" label="Speed" value="30" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Average speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['want' => 'speed', 'd' => 40, 'd-unit' => 'km', 't' => '1:20:00', 'v' => 30, 'v-unit' => 'kmh'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pace' => ['label' => 'Pace'],
            'time' => ['label' => 'Time'],
            'dist' => ['label' => 'Distance'],
            'per10' => ['label' => 'Time per 10 km'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
