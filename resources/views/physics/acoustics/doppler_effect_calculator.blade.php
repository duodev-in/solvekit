<x-calc.page
    title="Doppler Effect Calculator - SolveKit"
    description="Free Doppler effect calculator: observed frequency of sound or light from moving sources and observers."
    lede="Find the Doppler-shifted frequency."
    about="A moving source bunches waves ahead of it and stretches them behind, so the pitch rises as it approaches and falls as it leaves. For light the relativistic formula applies."
    :calc="['engine' => 'ph-wave', 'tool' => 'doppler', 'fields' => ['kind', 'f', 'c', 'vs', 'vo', 'v', 'out'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'c' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'vs' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'vo' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What does a 440 Hz horn on a car at 100 km/h sound like?', 'answer' => '478.773 Hz as it approaches.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Wave" :options="['sound' => 'Sound (or any wave in a medium)', 'light' => 'Light (relativistic)']" selected="sound" />
        <x-calc.field name="f" label="Emitted frequency" value="440" min="0" placeholder="Emitted frequency">
            <label for="calc-f-unit" class="sr-only">Emitted frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="kind:sound">
            <x-calc.field name="c" label="Wave speed in the medium" value="343" placeholder="Wave speed in the medium">
                <label for="calc-c-unit" class="sr-only">Wave speed in the medium unit</label>
                <select id="calc-c-unit" name="c-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:sound">
            <x-calc.field name="vs" label="Source speed toward the observer" value="100" placeholder="Source speed toward the observer">
                <label for="calc-vs-unit" class="sr-only">Source speed toward the observer unit</label>
                <select id="calc-vs-unit" name="vs-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:sound">
            <x-calc.field name="vo" label="Observer speed toward the source" value="0" placeholder="Observer speed toward the source">
                <label for="calc-vo-unit" class="sr-only">Observer speed toward the source unit</label>
                <select id="calc-vo-unit" name="vo-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:light">
            <x-calc.field name="v" label="Relative speed (positive = moving apart)" value="1000" placeholder="Relative speed (positive = moving apart)">
                <label for="calc-v-unit" class="sr-only">Relative speed (positive = moving apart) unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
    </div>

    <x-calc.result label="Observed frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hz', 'kind' => 'sound', 'f' => 440, 'f-unit' => 'hz', 'c' => 343, 'c-unit' => 'ms', 'vs' => 100, 'vs-unit' => 'kmh', 'vo' => 0, 'vo-unit' => 'kmh', 'v' => 1000, 'v-unit' => 'kms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'shift' => ['label' => 'Shift'],
            'after' => ['label' => 'After passing (moving apart)'],
            'z' => ['label' => 'Redshift z'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
