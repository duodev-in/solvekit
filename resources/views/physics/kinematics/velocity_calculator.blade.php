<x-calc.page
    title="Velocity Calculator - SolveKit"
    description="Free velocity calculator: average velocity from distance and time, or solve for either."
    lede="Solve v = d ÷ t."
    about="Average velocity is the displacement divided by the time taken. For a journey with stops it is the overall figure, not the speed shown on the dial."
    :calc="['engine' => 'ph-mech', 'tool' => 'velocity', 'fields' => ['solve', 'v', 'd', 't', 'out_v', 'out_d', 'out_t'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'time', 'v'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the average speed for 120 km in 2 h?', 'answer' => '60 km/h.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['v' => 'Average velocity', 'd' => 'Distance', 't' => 'Time']" selected="v" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:d,t" hidden>
            <x-calc.field name="v" label="Average velocity" value="60" placeholder="Average velocity">
                <label for="calc-v-unit" class="sr-only">Average velocity unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,t">
            <x-calc.field name="d" label="Distance" value="120" placeholder="Distance">
                <label for="calc-d-unit" class="sr-only">Distance unit</label>
                <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,d">
            <x-calc.field name="t" label="Time" value="2" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'h')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v">
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kmh" />
        </div>
        <div data-show-when="solve:d" hidden>
            <x-calc.select name="out_d" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="km" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="h" />
        </div>
    </div>

    <x-calc.result label="Average velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'v', 'v' => 60, 'v-unit' => 'kmh', 'out_v' => 'kmh', 'd' => 120, 'd-unit' => 'km', 'out_d' => 'km', 't' => 2, 't-unit' => 'h', 'out_t' => 'h'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>v = d ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
