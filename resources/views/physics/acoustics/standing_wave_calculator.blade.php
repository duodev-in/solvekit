<x-calc.page
    title="Standing Wave Calculator - SolveKit"
    description="Free standing wave calculator: harmonic frequencies of a string from its length, tension and linear density."
    lede="Find a string’s harmonics."
    about="A string fixed at both ends vibrates at f_n = n·v/2L, with wave speed √(T/μ). Tighter, lighter or shorter strings sound higher."
    :calc="['engine' => 'ph-wave', 'tool' => 'standing_wave', 'fields' => ['L', 'mode', 'T', 'mu', 'v', 'n', 'out'], 'unitFields' => ['L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'T' => collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What note does the example guitar string play?', 'answer' => '329.219 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="L" label="String length" value="64.8" placeholder="String length">
            <label for="calc-L-unit" class="sr-only">String length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mode" label="I know" :options="['tension' => 'Tension and linear density', 'speed' => 'The wave speed']" selected="tension" />
        <div data-show-when="mode:tension">
            <x-calc.field name="T" label="Tension" value="73" placeholder="Tension">
                <label for="calc-T-unit" class="sr-only">Tension unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.force'))->only(['n', 'kn', 'millinewton', 'meganewton', 'lbf', 'kgf', 'dyn', 'kip']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'n')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:tension">
            <x-calc.field name="mu" label="Linear density (g/m)" value="0.401" min="0" step="any" />
        </div>
        <div data-show-when="mode:speed">
            <x-calc.field name="v" label="Wave speed" value="427" placeholder="Wave speed">
                <label for="calc-v-unit" class="sr-only">Wave speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="n" label="Harmonics to list" value="6" min="1" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
    </div>

    <x-calc.result label="Fundamental frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hz', 'L' => 64.8, 'L-unit' => 'cm', 'mode' => 'tension', 'T' => 73, 'T-unit' => 'n', 'mu' => 0.401, 'v' => 427, 'v-unit' => 'ms', 'n' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'v' => ['label' => 'Wave speed'],
            'list' => ['label' => 'Harmonics'],
            'lambda' => ['label' => 'Fundamental wavelength (2L)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
