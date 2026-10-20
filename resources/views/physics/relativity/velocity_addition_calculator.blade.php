<x-calc.page
    title="Velocity Addition Calculator - SolveKit"
    description="Free relativistic velocity addition calculator: combine two speeds without ever exceeding light speed."
    lede="Add velocities relativistically."
    about="Speeds do not simply add: u = (v + w)/(1 + vw/c²). Two 0.6c and 0.7c speeds combine to 0.915c, not 1.3c."
    :calc="['engine' => 'ph-astro', 'tool' => 'velocity_addition', 'fields' => ['v', 'w', 'out'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'w' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.6c plus 0.7c?', 'answer' => '0.915493 c.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="v" label="Speed of the frame (ship)" value="0.6" placeholder="Speed of the frame (ship)">
            <label for="calc-v-unit" class="sr-only">Speed of the frame (ship) unit</label>
            <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w" label="Speed of the object in that frame" value="0.7" placeholder="Speed of the object in that frame">
            <label for="calc-w-unit" class="sr-only">Speed of the object in that frame unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="c" />
    </div>

    <x-calc.result label="Combined speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'v' => 0.6, 'v-unit' => 'c', 'w' => 0.7, 'w-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'classical' => ['label' => 'Simple sum (wrong)'],
            'gamma' => ['label' => 'Lorentz factor of the result'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
