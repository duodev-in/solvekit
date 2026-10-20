<x-calc.page
    title="Helmholtz Resonator Calculator - SolveKit"
    description="Free Helmholtz resonator calculator: resonant frequency of a cavity with a neck, like a bottle or bass trap."
    lede="Find the note a bottle makes."
    about="Blowing across a bottle makes the air in the neck bounce on the springy air in the body. The frequency is (c/2π)√(A/(V·L_eff)), where the neck length is extended by an end correction."
    :calc="['engine' => 'ph-wave', 'tool' => 'helmholtz', 'fields' => ['V', 'd', 'L', 'end', 'T', 'out'], 'unitFields' => ['V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed', 'temperature', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What note does a 750 ml wine bottle make?', 'answer' => 'About 112.099 Hz (A2 (110 Hz)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="V" label="Cavity volume" value="0.75" min="0" placeholder="Cavity volume">
            <label for="calc-V-unit" class="sr-only">Cavity volume unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Neck diameter" value="1.9" placeholder="Neck diameter">
            <label for="calc-d-unit" class="sr-only">Neck diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Neck length" value="7.6" placeholder="Neck length">
            <label for="calc-L-unit" class="sr-only">Neck length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="end" label="End correction" :options="['flanged' => 'One flanged end and one free end (1.45 r)', 'both' => 'Both ends flanged (1.7 r)', 'none' => 'None']" selected="flanged" />
        <x-calc.field name="T" label="Air temperature" value="20" placeholder="Air temperature">
            <label for="calc-T-unit" class="sr-only">Air temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
    </div>

    <x-calc.result label="Resonant frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hz', 'V' => 0.75, 'V-unit' => 'l', 'd' => 1.9, 'd-unit' => 'cm', 'L' => 7.6, 'L-unit' => 'cm', 'end' => 'flanged', 'T' => 20, 'T-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'c' => ['label' => 'Speed of sound used'],
            'Leff' => ['label' => 'Effective neck length'],
            'note' => ['label' => 'Nearest musical note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
