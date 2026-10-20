<x-calc.page
    title="Alfvén Velocity Calculator - SolveKit"
    description="Free Alfvén velocity calculator: speed of magnetohydrodynamic waves in a plasma from field, density and ion mass."
    lede="Find the Alfvén speed of a plasma."
    about="Alfvén waves travel along magnetic field lines in a plasma at B/√(μ₀ρ). In the solar wind near Earth (about 5 nT and 5 protons per cm³) the speed is around 50 km/s."
    :calc="['engine' => 'ph-wave', 'tool' => 'alfven', 'fields' => ['B', 'n', 'm', 'out'], 'unitFields' => ['B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all(), 'm' => collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'magnetic_field', 'mass', 'particle_mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the Alfvén speed in the solar wind example?', 'answer' => '48.7732 km/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="B" label="Magnetic field" value="5" placeholder="Magnetic field">
            <label for="calc-B-unit" class="sr-only">Magnetic field unit</label>
            <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nt')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="n" label="Ion number density (per cm³)" value="5" min="0" step="any" />
        <x-calc.field name="m" label="Ion mass" value="1.00727647" min="0" placeholder="Ion mass">
            <label for="calc-m-unit" class="sr-only">Ion mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.particle_mass'))->only(['kg', 'g', 'u', 'me', 'mevc2']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'u')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kms" />
    </div>

    <x-calc.result label="Alfvén speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'kms', 'B' => 5, 'B-unit' => 'nt', 'n' => 5, 'm' => 1.00727647, 'm-unit' => 'u'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rho' => ['label' => 'Mass density'],
            'beta' => ['label' => 'Fraction of c'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
