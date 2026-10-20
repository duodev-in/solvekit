<x-calc.page
    title="Sound Wavelength Calculator - SolveKit"
    description="Free sound wavelength calculator: wavelength of sound in air at any temperature, or in water."
    lede="Find the wavelength of a sound."
    about="Wavelength is the speed of sound divided by frequency. In air at 20 °C, 1 kHz has a wavelength of about 34 cm; a 20 Hz bass note is 17 m long."
    :calc="['engine' => 'ph-wave', 'tool' => 'sound_wavelength', 'fields' => ['f', 'med', 'T', 'c', 'out'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'c' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'short_time', 'speed', 'temperature'])->all(), 'physics' => collect(config('physics_data'))->only(['sound_media'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the wavelength of 1 kHz in air?', 'answer' => '34.3235 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="f" label="Frequency" value="1000" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="med" label="Medium" :options="['air' => 'Air at the temperature below', 'water' => 'Fresh water (1,482 m/s)', 'seawater' => 'Sea water (1,522 m/s)', 'custom' => 'Other (enter the speed)']" selected="air" />
        <div data-show-when="med:air">
            <x-calc.field name="T" label="Air temperature" value="20" placeholder="Air temperature">
                <label for="calc-T-unit" class="sr-only">Air temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="med:custom">
            <x-calc.field name="c" label="Speed of sound" value="343" placeholder="Speed of sound">
                <label for="calc-c-unit" class="sr-only">Speed of sound unit</label>
                <select id="calc-c-unit" name="c-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
    </div>

    <x-calc.result label="Wavelength" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'cm', 'f' => 1000, 'f-unit' => 'hz', 'med' => 'air', 'T' => 20, 'T-unit' => 'c', 'c' => 343, 'c-unit' => 'ms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'c' => ['label' => 'Speed of sound'],
            'T' => ['label' => 'Period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
