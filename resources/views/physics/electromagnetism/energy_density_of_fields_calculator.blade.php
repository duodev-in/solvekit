<x-calc.page
    title="Energy Density of Fields Calculator - SolveKit"
    description="Free electromagnetic energy density calculator: energy stored per volume in electric and magnetic fields."
    lede="Find field energy density."
    about="Fields store energy: ½εE² for electric and B²/2μ for magnetic fields. A 1 T field stores about 400 kJ per cubic metre."
    :calc="['engine' => 'ph-em', 'tool' => 'field_energy', 'fields' => ['E', 'B', 'er', 'mur', 'V'], 'unitFields' => ['E' => collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm'])->all(), 'B' => collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss'])->all(), 'V' => collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk'])->all()], 'data' => ['units' => collect(config('units'))->only(['electric_field', 'energy', 'force', 'length', 'magnetic_field', 'mass', 'speed', 'volume'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the energy density of 1 T?', 'answer' => '397,887 J/m³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="E" label="Electric field" value="100" placeholder="Electric field">
            <label for="calc-E-unit" class="sr-only">Electric field unit</label>
            <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kvpm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="B" label="Magnetic field" value="1" placeholder="Magnetic field">
            <label for="calc-B-unit" class="sr-only">Magnetic field unit</label>
            <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.magnetic_field'))->only(['t', 'mt', 'ut', 'nt', 'gauss', 'mgauss']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 't')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="er" label="Relative permittivity" value="1" min="1" step="any" />
        <x-calc.field name="mur" label="Relative permeability" value="1" min="1" step="any" />
        <x-calc.field name="V" label="Volume (optional)" value="1" min="0" placeholder="Volume (optional)">
            <label for="calc-V-unit" class="sr-only">Volume (optional) unit</label>
            <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.volume'))->only(['m3', 'l', 'ml', 'ft3', 'in3', 'gal_us', 'gal_uk']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'l')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Energy density" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['E' => 100, 'E-unit' => 'kvpm', 'B' => 1, 'B-unit' => 't', 'er' => 1, 'mur' => 1, 'V' => 1, 'V-unit' => 'l'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'uE' => ['label' => 'Electric part ½εE²'],
            'uB' => ['label' => 'Magnetic part B² ÷ 2μ'],
            'total' => ['label' => 'Energy in that volume'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
