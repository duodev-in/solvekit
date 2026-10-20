<x-calc.page
    title="Magnetic Force Between Current-Carrying Wires Calculator - SolveKit"
    description="Free force between wires calculator: attraction or repulsion of parallel currents."
    lede="Find the force between two wires."
    about="Parallel currents attract and opposite currents repel with force μ₀I₁I₂L/2πd. The ampere was once defined this way."
    :calc="['engine' => 'ph-elec', 'tool' => 'wires_force', 'fields' => ['I1', 'I2', 'd', 'L', 'dir', 'out'], 'unitFields' => ['I1' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'I2' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'd' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What force do two 10 A wires 1 cm apart feel per metre?', 'answer' => '2 mN.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="I1" label="Current in wire 1" value="10" placeholder="Current in wire 1">
            <label for="calc-I1-unit" class="sr-only">Current in wire 1 unit</label>
            <select id="calc-I1-unit" name="I1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="I2" label="Current in wire 2" value="10" placeholder="Current in wire 2">
            <label for="calc-I2-unit" class="sr-only">Current in wire 2 unit</label>
            <select id="calc-I2-unit" name="I2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d" label="Separation" value="1" placeholder="Separation">
            <label for="calc-d-unit" class="sr-only">Separation unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Length" value="1" placeholder="Length">
            <label for="calc-L-unit" class="sr-only">Length unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="dir" label="Currents flow" :options="['same' => 'The same way', 'opposite' => 'Opposite ways']" selected="same" />
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="millinewton" />
    </div>

    <x-calc.result label="Force between the wires" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'millinewton', 'I1' => 10, 'I1-unit' => 'a', 'I2' => 10, 'I2-unit' => 'a', 'd' => 1, 'd-unit' => 'cm', 'L' => 1, 'L-unit' => 'm', 'dir' => 'same'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'per' => ['label' => 'Force per metre'],
            'kind' => ['label' => 'Effect'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
