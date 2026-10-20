<x-calc.page
    title="Radar Horizon Calculator - SolveKit"
    description="Free radar horizon calculator: maximum line-of-sight radar range from antenna and target heights."
    lede="Find the radar horizon."
    about="Radio waves bend around the Earth a little more than light, which is modelled with an effective Earth radius 4/3 of the real one. Range is the sum of the antenna’s and the target’s horizons."
    :calc="['engine' => 'ph-wave', 'tool' => 'radar_horizon', 'fields' => ['h1', 'h2', 'k', 'out'], 'unitFields' => ['h1' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h2' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the radar horizon for a 30 m antenna and a 10 m target?', 'answer' => '35.6104 km.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h1" label="Antenna height" value="30" placeholder="Antenna height">
            <label for="calc-h1-unit" class="sr-only">Antenna height unit</label>
            <select id="calc-h1-unit" name="h1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h2" label="Target height" value="10" placeholder="Target height">
            <label for="calc-h2-unit" class="sr-only">Target height unit</label>
            <select id="calc-h2-unit" name="h2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="k" label="Refraction" :options="['radar' => 'Standard radio (k = 4/3)', 'optical' => 'Optical (k ≈ 1.15)', 'none' => 'Geometric (k = 1)']" selected="radar" />
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="km" />
    </div>

    <x-calc.result label="Radar horizon" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'km', 'h1' => 30, 'h1-unit' => 'm', 'h2' => 10, 'h2-unit' => 'm', 'k' => 'radar'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Antenna horizon'],
            'b' => ['label' => 'Target horizon'],
            'nmi' => ['label' => 'In nautical miles'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
