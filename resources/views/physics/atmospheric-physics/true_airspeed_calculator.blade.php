<x-calc.page
    title="True Airspeed Calculator - SolveKit"
    description="Free true airspeed calculator: TAS from calibrated airspeed, pressure altitude and temperature."
    lede="Find true airspeed."
    about="The airspeed indicator reads dynamic pressure, so in thin air it under-reads. True airspeed corrects for density, and for compressibility at higher speeds."
    :calc="['engine' => 'ph-thermo', 'tool' => 'true_airspeed', 'fields' => ['cas', 'alt', 'mode', 'T', 'out'], 'unitFields' => ['cas' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'alt' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the TAS for 150 kt at 10,000 ft (ISA)?', 'answer' => '174.04 kn.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cas" label="Calibrated (indicated) airspeed" value="150" placeholder="Calibrated (indicated) airspeed">
            <label for="calc-cas-unit" class="sr-only">Calibrated (indicated) airspeed unit</label>
            <select id="calc-cas-unit" name="cas-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'knot')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="alt" label="Pressure altitude" value="10000" placeholder="Pressure altitude">
            <label for="calc-alt-unit" class="sr-only">Pressure altitude unit</label>
            <select id="calc-alt-unit" name="alt-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mode" label="Temperature" :options="['isa' => 'Standard (ISA)', 'oat' => 'Outside air temperature']" selected="isa" />
        <div data-show-when="mode:oat">
            <x-calc.field name="T" label="Outside air temperature" value="-5" placeholder="Outside air temperature">
                <label for="calc-T-unit" class="sr-only">Outside air temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="knot" />
    </div>

    <x-calc.result label="True airspeed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'knot', 'cas' => 150, 'cas-unit' => 'knot', 'alt' => 10000, 'alt-unit' => 'ft', 'mode' => 'isa', 'T' => -5, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mach' => ['label' => 'Mach number'],
            'eas' => ['label' => 'Equivalent airspeed'],
            'rule' => ['label' => 'Rule of thumb (+2% per 1,000 ft)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
