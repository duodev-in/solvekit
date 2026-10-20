<x-calc.page
    title="Lorentz Force Calculator - SolveKit"
    description="Free Lorentz force calculator: force on a moving charge in electric and magnetic fields, as vectors."
    lede="Find F = q(E + v × B)."
    about="A charge feels qE from an electric field and q v × B from a magnetic field, perpendicular to both its velocity and the field."
    :calc="['engine' => 'ph-em', 'tool' => 'lorentz_force', 'fields' => ['q', 'vx', 'vy', 'vz', 'Ex', 'Ey', 'Ez', 'Bx', 'By', 'Bz', 'out'], 'unitFields' => ['q' => collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e'])->all()], 'data' => ['units' => collect(config('units'))->only(['charge', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What force acts on a proton at 10⁵ m/s across 0.5 T?', 'answer' => '8.01088 × 10⁻¹⁵ N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="q" label="Charge" value="1" placeholder="Charge">
            <label for="calc-q-unit" class="sr-only">Charge unit</label>
            <select id="calc-q-unit" name="q-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.charge'))->only(['c', 'mc', 'uc', 'nc', 'ah', 'mah', 'e']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'e')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="vx" label="vₓ (m/s)" value="100000" step="any" />
        <x-calc.field name="vy" label="v_y (m/s)" value="0" step="any" />
        <x-calc.field name="vz" label="v_z (m/s)" value="0" step="any" />
        <x-calc.field name="Ex" label="Eₓ (V/m)" value="0" step="any" />
        <x-calc.field name="Ey" label="E_y (V/m)" value="0" step="any" />
        <x-calc.field name="Ez" label="E_z (V/m)" value="0" step="any" />
        <x-calc.field name="Bx" label="Bₓ (T)" value="0" step="any" />
        <x-calc.field name="By" label="B_y (T)" value="0" step="any" />
        <x-calc.field name="Bz" label="B_z (T)" value="0.5" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Lorentz force magnitude" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'q' => 1, 'q-unit' => 'e', 'vx' => 100000, 'vy' => 0, 'vz' => 0, 'Ex' => 0, 'Ey' => 0, 'Ez' => 0, 'Bx' => 0, 'By' => 0, 'Bz' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'comps' => ['label' => 'Force components (x, y, z)'],
            'electric' => ['label' => 'Electric part qE'],
            'magnetic' => ['label' => 'Magnetic part q v × B'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
