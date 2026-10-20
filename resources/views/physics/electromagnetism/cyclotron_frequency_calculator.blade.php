<x-calc.page
    title="Cyclotron Frequency Calculator - SolveKit"
    description="Free cyclotron frequency calculator: gyration frequency and radius of a charged particle in a magnetic field."
    lede="Find the cyclotron frequency."
    about="A charged particle in a magnetic field circles at f = qB/2πm, independent of its speed (until it becomes relativistic). Electrons in 1 T circle at 28 GHz."
    :calc="['engine' => 'ph-em', 'tool' => 'cyclotron', 'fields' => ['particle', 'q', 'm', 'B', 'v', 'out'], 'unitFields' => ['q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'm' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all(), 'B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'energy', 'force', 'frequency_hz', 'length', 'magnetic_field', 'mass', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the electron cyclotron frequency at 1 T?', 'answer' => '27.9925 GHz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="particle" label="Particle" :options="['electron' => 'Electron', 'proton' => 'Proton', 'alpha' => 'Alpha particle', 'deuteron' => 'Deuteron', 'custom' => 'Other']" selected="electron" />
        <div data-show-when="particle:custom">
            <x-calc.field name="q" label="Charge" value="1" placeholder="Charge">
                <label for="calc-q-unit" class="sr-only">Charge unit</label>
                <select id="calc-q-unit" name="q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'e')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="particle:custom">
            <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'u')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="B" label="Magnetic field" value="1" placeholder="Magnetic field">
            <label for="calc-B-unit" class="sr-only">Magnetic field unit</label>
            <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="v" label="Speed (optional, for the radius)" value="1000" placeholder="Speed (optional, for the radius)">
            <label for="calc-v-unit" class="sr-only">Speed (optional, for the radius) unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kms')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="ghz" />
    </div>

    <x-calc.result label="Cyclotron frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ghz', 'particle' => 'electron', 'q' => 1, 'q-unit' => 'e', 'm' => 1, 'm-unit' => 'u', 'B' => 1, 'B-unit' => 't', 'v' => 1000, 'v-unit' => 'kms'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'w' => ['label' => 'Angular frequency'],
            'r' => ['label' => 'Orbit (Larmor) radius'],
            'T' => ['label' => 'Period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
