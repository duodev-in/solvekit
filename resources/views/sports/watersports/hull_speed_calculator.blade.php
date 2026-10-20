<x-calc.page
    title="Hull Speed Calculator - SolveKit"
    description="Free hull speed calculator: the top speed of a displacement hull from waterline length."
    lede="Find hull speed."
    about="A displacement hull struggles to go faster than 1.34 √(waterline length in feet) knots, where it climbs its own bow wave."
    :calc="['engine' => 'sp-misc', 'tool' => 'hull_speed', 'fields' => ['lwl', 'k', 'out'], 'unitFields' => ['lwl' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the hull speed of a 30 ft waterline?', 'answer' => '7.33948 kn.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lwl" label="Waterline length" value="30" placeholder="Waterline length">
            <label for="calc-lwl-unit" class="sr-only">Waterline length unit</label>
            <select id="calc-lwl-unit" name="lwl-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="k" label="Speed–length ratio" value="1.34" min="0.5" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="knot" />
    </div>

    <x-calc.result label="Hull speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'knot', 'lwl' => 30, 'lwl-unit' => 'ft', 'k' => 1.34],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kmh' => ['label' => 'In km/h'],
            'note' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
