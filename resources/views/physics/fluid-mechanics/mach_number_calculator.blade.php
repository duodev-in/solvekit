<x-calc.page
    title="Mach Number Calculator - SolveKit"
    description="Free Mach number calculator: speed relative to the speed of sound at a temperature or altitude."
    lede="Find the Mach number."
    about="The speed of sound depends on temperature, so the same speed is a higher Mach number in cold high-altitude air."
    :calc="['engine' => 'ph-fluid', 'tool' => 'mach', 'fields' => ['v', 'mode', 'T', 'alt', 'gamma', 'M'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'alt' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What Mach is 900 km/h at 11 km?', 'answer' => '0.847.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Speed" value="900" placeholder="Speed">
            <label for="calc-v-unit" class="sr-only">Speed unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mode" label="Air temperature from" :options="['T' => 'A temperature', 'alt' => 'Standard atmosphere at an altitude']" selected="alt" />
        <div data-show-when="mode:T">
            <x-calc.field name="T" label="Temperature" value="15" placeholder="Temperature">
                <label for="calc-T-unit" class="sr-only">Temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:alt">
            <x-calc.field name="alt" label="Altitude" value="11000" placeholder="Altitude">
                <label for="calc-alt-unit" class="sr-only">Altitude unit</label>
                <select id="calc-alt-unit" name="alt-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="gamma" label="Ratio of specific heats γ" value="1.4" min="1" step="any" />
        <x-calc.field name="M" label="Molar mass (g/mol)" value="28.9647" min="0" step="any" />
    </div>

    <x-calc.result label="Mach number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['v' => 900, 'v-unit' => 'kmh', 'mode' => 'alt', 'T' => 15, 'T-unit' => 'c', 'alt' => 11000, 'alt-unit' => 'm', 'gamma' => 1.4, 'M' => 28.9647],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Speed of sound'],
            'regime' => ['label' => 'Regime'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
