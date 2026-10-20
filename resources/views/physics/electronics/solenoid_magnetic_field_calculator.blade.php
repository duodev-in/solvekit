<x-calc.page
    title="Solenoid Magnetic Field Calculator - SolveKit"
    description="Free solenoid magnetic field calculator: field inside a solenoid with the finite-length correction."
    lede="Find the field in a solenoid."
    about="Inside a long solenoid the field is uniform: B = μ₀nI. Short solenoids are weaker at the centre and half as strong at the ends."
    :calc="['engine' => 'ph-elec', 'tool' => 'solenoid_field', 'fields' => ['N', 'l', 'I', 'mur', 'd', 'out'], 'unitFields' => ['l' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'magnetic_field', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What field do 500 turns over 10 cm make at 2 A?', 'answer' => '12.3223 mT.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="N" label="Turns" value="500" min="1" step="any" />
        <x-calc.field name="l" label="Length" value="10" placeholder="Length">
            <label for="calc-l-unit" class="sr-only">Length unit</label>
            <select id="calc-l-unit" name="l-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I" label="Current" value="2" placeholder="Current">
            <label for="calc-I-unit" class="sr-only">Current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="mur" label="Core relative permeability (1 for air)" value="1" min="0" step="any" />
        <x-calc.field name="d" label="Diameter (optional, for the finite-length correction)" value="2" placeholder="Diameter (optional, for the finite-length correction)">
            <label for="calc-d-unit" class="sr-only">Diameter (optional, for the finite-length correction) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['t' => 'T', 'mt' => 'mT', 'ut' => 'µT', 'nt' => 'nT', 'gauss' => 'G', 'mgauss' => 'mG']" selected="mt" />
    </div>

    <x-calc.result label="Field inside (centre)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mt', 'N' => 500, 'l' => 10, 'l-unit' => 'cm', 'I' => 2, 'I-unit' => 'a', 'mur' => 1, 'd' => 2, 'd-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ideal' => ['label' => 'Ideal long solenoid μ₀nI'],
            'end' => ['label' => 'At each end (finite solenoid)'],
            'H' => ['label' => 'Field strength H'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
