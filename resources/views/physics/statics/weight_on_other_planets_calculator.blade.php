<x-calc.page
    title="Weight on Other Planets Calculator - SolveKit"
    description="Free weight on other planets calculator: what you would weigh on every planet, the Moon and other moons."
    lede="Find your weight across the solar system."
    about="Your mass is the same everywhere; your weight is mass × the local surface gravity GM/r². Gravity comes from NASA/JPL values of each body’s GM and mean radius."
    :calc="['engine' => 'ph-mech', 'tool' => 'weight_planets', 'fields' => ['m', 'out'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What would 70 kg weigh on the Moon?', 'answer' => 'It would read 11.58 kg-weight on a scale calibrated for Earth.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="m" label="Your mass (or Earth weight in kg or lb)" value="70" min="0" placeholder="Your mass (or Earth weight in kg or lb)">
            <label for="calc-m-unit" class="sr-only">Your mass (or Earth weight in kg or lb) unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
    </div>

    <x-calc.result label="Weight on Earth" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'n', 'm' => 70, 'm-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'moon' => ['label' => 'Moon'],
            'mars' => ['label' => 'Mars'],
            'jupiter' => ['label' => 'Jupiter'],
            'table' => ['label' => 'Every body (as Earth-kilograms on a bathroom scale)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Weight on each body" name="planets" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
