<x-calc.page
    title="Earth Curvature Calculator - SolveKit"
    description="Free Earth curvature calculator: how much of a distant object is hidden by the curve of the Earth."
    lede="Find how much is hidden below the horizon."
    about="Beyond your horizon the Earth’s curve hides the bottom of distant objects. The hidden height depends on the distance, your eye height and atmospheric refraction."
    :calc="['engine' => 'ph-wave', 'tool' => 'curvature', 'fields' => ['d', 'h', 'refr', 'out'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How much is hidden at 10 km from 2 m eye height?', 'answer' => '1.43711 m.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d" label="Distance to the object" value="10" placeholder="Distance to the object">
            <label for="calc-d-unit" class="sr-only">Distance to the object unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Eye height" value="2" placeholder="Eye height">
            <label for="calc-h-unit" class="sr-only">Eye height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="refr" label="Refraction" :options="['none' => 'Ignore refraction', 'standard' => 'Standard atmosphere (k = 0.13)']" selected="standard" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Hidden height" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'd' => 10, 'd-unit' => 'km', 'h' => 2, 'h-unit' => 'm', 'refr' => 'standard'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'drop' => ['label' => 'Drop below a level line'],
            'horizon' => ['label' => 'Your horizon distance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
