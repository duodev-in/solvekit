<x-calc.page
    title="Hill Sphere Calculator - SolveKit"
    description="Free Hill sphere calculator: the region where a planet’s gravity dominates its star’s, and where moons can orbit."
    lede="Find a Hill sphere."
    about="Within its Hill sphere a planet can hold satellites against its star’s pull. Earth’s reaches about 1.5 million km; stable moons stay within about half of it."
    :calc="['engine' => 'ph-astro', 'tool' => 'hill_sphere', 'fields' => ['M', 'm', 'a', 'e', 'out'], 'unitFields' => ['M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'm' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'a' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How big is Earth’s Hill sphere?', 'answer' => '1,471,570 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="M" label="Central mass" value="1" min="0" placeholder="Central mass">
            <label for="calc-M-unit" class="sr-only">Central mass unit</label>
            <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'msun')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="m" label="Orbiting body mass" value="1" min="0" placeholder="Orbiting body mass">
            <label for="calc-m-unit" class="sr-only">Orbiting body mass unit</label>
            <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mearth')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="a" label="Semi-major axis" value="1" min="0" placeholder="Semi-major axis">
            <label for="calc-a-unit" class="sr-only">Semi-major axis unit</label>
            <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'au')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="e" label="Eccentricity" value="0.0167" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'au' => 'AU', 'ly' => 'ly', 'pc' => 'pc', 'mpc' => 'Mpc', 'mi' => 'mi']" selected="km" />
    </div>

    <x-calc.result label="Hill sphere radius" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'km', 'M' => 1, 'M-unit' => 'msun', 'm' => 1, 'm-unit' => 'mearth', 'a' => 1, 'a-unit' => 'au', 'e' => 0.0167],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'au' => ['label' => 'In AU'],
            'moons' => ['label' => 'Stable moons orbit within about'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
