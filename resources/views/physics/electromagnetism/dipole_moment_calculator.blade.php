<x-calc.page
    title="Dipole Moment Calculator - SolveKit"
    description="Free electric dipole moment calculator: p = qd in C·m and debye, with torque in a field."
    lede="Find an electric dipole moment."
    about="Two equal and opposite charges a distance apart form a dipole with moment p = qd, pointing from − to +. Molecules are measured in debye."
    :calc="['engine' => 'ph-em', 'tool' => 'dipole_moment', 'fields' => ['q', 'd', 'E'], 'unitFields' => ['q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'E' => collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'electric_field', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is p for ±e separated by 0.1 nm?', 'answer' => '1.60218 × 10⁻²⁹ C·m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q" label="Charge magnitude" value="1" placeholder="Charge magnitude">
            <label for="calc-q-unit" class="sr-only">Charge magnitude unit</label>
            <select id="calc-q-unit" name="q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'e')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Separation" value="0.1" placeholder="Separation">
            <label for="calc-d-unit" class="sr-only">Separation unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="E" label="External field (optional, for torque)" value="1" placeholder="External field (optional, for torque)">
            <label for="calc-E-unit" class="sr-only">External field (optional, for torque) unit</label>
            <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.electric_field'))->only(['vpm', 'kvpm', 'vpcm', 'kvpcm', 'mvpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mvpm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Electric dipole moment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q' => 1, 'q-unit' => 'e', 'd' => 0.1, 'd-unit' => 'nm', 'E' => 1, 'E-unit' => 'mvpm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'debye' => ['label' => 'In debye'],
            'torque' => ['label' => 'Maximum torque in that field'],
            'U' => ['label' => 'Energy range in that field'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
