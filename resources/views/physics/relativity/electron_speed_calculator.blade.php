<x-calc.page
    title="Electron Speed Calculator - SolveKit"
    description="Free electron speed calculator: relativistic electron speed from accelerating voltage or kinetic energy."
    lede="Find electron speed."
    about="An electron accelerated through V volts gains eV of energy. Above a few kV the classical formula fails; the relativistic one keeps it below c."
    :calc="['engine' => 'ph-astro', 'tool' => 'electron_speed', 'fields' => ['mode', 'V', 'E', 'out'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'E' => collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'particle_energy', 'speed', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast is a 100 keV electron?', 'answer' => '0.548221 c.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['volts' => 'Accelerating voltage', 'ke' => 'Kinetic energy']" selected="volts" />
        <div data-show-when="mode:volts">
            <x-calc.field name="V" label="Accelerating voltage" value="100" placeholder="Accelerating voltage">
                <label for="calc-V-unit" class="sr-only">Accelerating voltage unit</label>
                <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kv')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:ke">
            <x-calc.field name="E" label="Kinetic energy" value="100" min="0" placeholder="Kinetic energy">
                <label for="calc-E-unit" class="sr-only">Kinetic energy unit</label>
                <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.particle_energy'))->only(['ev', 'mev_milli', 'kev', 'mev', 'gev', 'j', 'zj']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kev')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="c" />
    </div>

    <x-calc.result label="Electron speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'mode' => 'volts', 'V' => 100, 'V-unit' => 'kv', 'E' => 100, 'E-unit' => 'kev'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kms' => ['label' => 'In km/s'],
            'gamma' => ['label' => 'Lorentz factor γ'],
            'classical' => ['label' => 'Classical (wrong at high energy)'],
            'lambda' => ['label' => 'De Broglie wavelength'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
