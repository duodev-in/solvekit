<x-calc.page
    title="Solenoid Inductance Calculator - SolveKit"
    description="Free solenoid inductance calculator: inductance of a single-layer coil with the exact Nagaoka correction."
    lede="Find a coil’s inductance."
    about="A long solenoid has L = μ₀N²A/l; short coils have less, by Nagaoka’s coefficient, which this calculator evaluates exactly from elliptic integrals."
    :calc="['engine' => 'ph-elec', 'tool' => 'solenoid_inductance', 'fields' => ['N', 'l', 'd', 'mur', 'out'], 'unitFields' => ['l' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'inductance', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the inductance of 100 turns, 5 cm long, 2 cm across?', 'answer' => '67.1017 µH.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="N" label="Turns" value="100" min="1" step="any" />
        <x-calc.field name="l" label="Coil length" value="5" placeholder="Coil length">
            <label for="calc-l-unit" class="sr-only">Coil length unit</label>
            <select id="calc-l-unit" name="l-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Coil diameter (to the wire centre)" value="2" placeholder="Coil diameter (to the wire centre)">
            <label for="calc-d-unit" class="sr-only">Coil diameter (to the wire centre) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mur" label="Core relative permeability (1 for air)" value="1" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['h' => 'H', 'mh' => 'mH', 'uh' => 'µH', 'nh' => 'nH']" selected="uh" />
    </div>

    <x-calc.result label="Inductance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'uh', 'N' => 100, 'l' => 5, 'l-unit' => 'cm', 'd' => 2, 'd-unit' => 'cm', 'mur' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ideal' => ['label' => 'Long-solenoid formula (no correction)'],
            'K' => ['label' => 'Nagaoka coefficient'],
            'wheeler' => ['label' => 'Wheeler’s approximation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
