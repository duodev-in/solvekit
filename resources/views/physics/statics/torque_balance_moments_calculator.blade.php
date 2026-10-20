<x-calc.page
    title="Torque Balance (Moments) Calculator - SolveKit"
    description="Free moments calculator: the force needed to balance a lever or beam from the other forces and their distances."
    lede="Balance moments about a pivot."
    about="An object is balanced when the clockwise moments equal the anticlockwise moments. Each moment is a force times its distance from the pivot."
    :calc="['engine' => 'ph-mech', 'tool' => 'moments', 'fields' => ['forces', 'd', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What balances 200 N at −1.5 m and 100 N at 2 m with a force at 1 m?', 'answer' => '100 N.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="forces" label="Forces: force in N, distance from the pivot in m (positive = anticlockwise)" value="200, -1.5
100, 2" rows="3" />
        <x-calc.field name="d" label="Where the balancing force acts (distance)" value="1" placeholder="Where the balancing force acts (distance)">
            <label for="calc-d-unit" class="sr-only">Where the balancing force acts (distance) unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Force needed to balance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'forces' => '200, -1.5
100, 2', 'd' => 1, 'd-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'net' => ['label' => 'Net moment now'],
            'dir' => ['label' => 'Direction of the balancing force'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
