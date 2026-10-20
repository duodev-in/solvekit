<x-calc.page
    title="Broad Crested Weir Calculator - SolveKit"
    description="Free broad-crested weir calculator: discharge over a weir from head and crest width."
    lede="Find flow over a broad-crested weir."
    about="Water passing over a broad crest becomes critical, with depth two-thirds of the head. The flow then depends only on the head and the crest width."
    :calc="['engine' => 'ph-fluid', 'tool' => 'broad_weir', 'fields' => ['H', 'b', 'Cd', 'out'], 'unitFields' => ['H' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'b' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'flow', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What flows over a 2 m crest with 0.3 m of head?', 'answer' => '0.475041 m³/s.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="H" label="Head above the crest" value="0.3" placeholder="Head above the crest">
            <label for="calc-H-unit" class="sr-only">Head above the crest unit</label>
            <select id="calc-H-unit" name="H-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="b" label="Crest width" value="2" placeholder="Crest width">
            <label for="calc-b-unit" class="sr-only">Crest width unit</label>
            <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Cd" label="Discharge coefficient" value="0.848" min="0" step="any" />
        <x-calc.select name="out" label="Show the result in" :options="['m3s' => 'm³/s', 'm3h' => 'm³/h', 'ls' => 'L/s', 'lmin' => 'L/min', 'gpm' => 'gpm', 'cfm' => 'cfm', 'cfs' => 'ft³/s']" selected="m3s" />
    </div>

    <x-calc.result label="Flow rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm3s', 'H' => 0.3, 'H-unit' => 'm', 'b' => 2, 'b-unit' => 'm', 'Cd' => 0.848],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'yc' => ['label' => 'Critical depth on the crest'],
            'ls' => ['label' => 'In litres per second'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
