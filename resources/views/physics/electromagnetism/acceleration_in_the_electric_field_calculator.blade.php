<x-calc.page
    title="Acceleration in the Electric Field Calculator - SolveKit"
    description="Free electric field acceleration calculator: acceleration of an electron, proton or ion in an electric field."
    lede="Find how fast a charge accelerates in a field."
    about="A charge in an electric field feels a force qE, so it accelerates at qE/m. Electrons are 1,836 times lighter than protons, so they accelerate that much faster in the same field."
    :calc="['engine' => 'ph-em', 'tool' => 'e_field_accel', 'fields' => ['particle', 'q', 'm', 'E', 'out'], 'unitFields' => ['q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'm' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all(), 'E' => collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'charge', 'electric_field', 'energy', 'force', 'length', 'mass', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast does an electron accelerate in 1 kV/m?', 'answer' => '175,882,000,000,000 m/s².'],
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
        <x-calc.field name="E" label="Electric field" value="1" placeholder="Electric field">
            <label for="calc-E-unit" class="sr-only">Electric field unit</label>
            <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kvpm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
    </div>

    <x-calc.result label="Acceleration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms2', 'particle' => 'electron', 'q' => 1, 'q-unit' => 'e', 'm' => 1, 'm-unit' => 'u', 'E' => 1, 'E-unit' => 'kvpm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'F' => ['label' => 'Force'],
            'g' => ['label' => 'Compared with gravity'],
            't' => ['label' => 'Time to reach 1% of light speed from rest'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
