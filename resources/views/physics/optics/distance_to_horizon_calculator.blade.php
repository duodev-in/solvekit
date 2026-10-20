<x-calc.page
    title="Distance to Horizon Calculator - SolveKit"
    description="Free distance to horizon calculator: how far you can see from any height, with standard atmospheric refraction."
    lede="Find how far away the horizon is."
    about="From height h the horizon is √(2Rh + h²) away on a sphere of radius R. The atmosphere bends light slightly downward, which makes the Earth look flatter; the standard refraction coefficient 0.13 adds about 7%."
    :calc="['engine' => 'ph-wave', 'tool' => 'horizon', 'fields' => ['h', 'target', 'refr', 'out'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'target' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far is the horizon for eyes 1.7 m up?', 'answer' => '4.98981 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h" label="Eye height" value="1.7" placeholder="Eye height">
            <label for="calc-h-unit" class="sr-only">Eye height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="target" label="Target height (optional)" value="0" placeholder="Target height (optional)">
            <label for="calc-target-unit" class="sr-only">Target height (optional) unit</label>
            <select id="calc-target-unit" name="target-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="refr" label="Refraction" :options="['none' => 'Ignore refraction', 'standard' => 'Standard atmosphere (k = 0.13)']" selected="standard" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="km" />
    </div>

    <x-calc.result label="Distance to the horizon" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'km', 'h' => 1.7, 'h-unit' => 'm', 'target' => 0, 'target-unit' => 'm', 'refr' => 'standard'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'geo' => ['label' => 'Without refraction'],
            'seen' => ['label' => 'Target top visible up to'],
            'dip' => ['label' => 'Dip of the horizon'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
