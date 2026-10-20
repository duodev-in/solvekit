<x-calc.page
    title="Drift Velocity Calculator - SolveKit"
    description="Free drift velocity calculator: how fast electrons actually move in a wire carrying current."
    lede="Find electron drift velocity."
    about="Electrons in a wire shuffle along at well under a millimetre per second, even though the signal travels near light speed. v_d = I/(neA)."
    :calc="['engine' => 'ph-em', 'tool' => 'drift_velocity', 'fields' => ['I', 'd', 'mat', 'out'], 'unitFields' => ['I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['conductors'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How fast do electrons drift in 2.5 mm copper wire at 10 A?', 'answer' => '0.000150119 m/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="I" label="Current" value="10" placeholder="Current">
            <label for="calc-I-unit" class="sr-only">Current unit</label>
            <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Wire diameter" value="2.5" placeholder="Wire diameter">
            <label for="calc-d-unit" class="sr-only">Wire diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="mat" label="Conductor" :options="['copper' => 'Copper (annealed)', 'aluminium' => 'Aluminium (EC grade)', 'silver' => 'Silver', 'gold' => 'Gold', 'tungsten' => 'Tungsten', 'brass' => 'Brass', 'iron' => 'Iron (pure)', 'steel' => 'Carbon steel', 'stainless' => 'Stainless steel 304', 'constantan' => 'Constantan', 'nichrome' => 'Nichrome (80/20)']" selected="copper" />
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
    </div>

    <x-calc.result label="Drift velocity" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ms', 'I' => 10, 'I-unit' => 'a', 'd' => 2.5, 'd-unit' => 'mm', 'mat' => 'copper'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mmps' => ['label' => 'In mm per second'],
            'J' => ['label' => 'Current density'],
            'metre' => ['label' => 'Time to drift 1 m'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
