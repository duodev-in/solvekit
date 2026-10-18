<x-calc.page
    title="Tablecloth Size Calculator - SolveKit"
    description="Free tablecloth size calculator: the tablecloth size for a rectangular, square or round table from its size and the drop you want, with the nearest standard size."
    lede="Find the right tablecloth size."
    about="Tablecloth size = table size + 2 × drop. Casual tables use a 6–8 in drop, formal dining 10–15 in, and floor-length cloths about 29–30 in (table height). Standard sizes are listed; round tables use round cloths of the table diameter + 2 × drop."
    :calc="['engine' => 'ev-clothing', 'tool' => 'tablecloth', 'fields' => ['shape', 'drop', 'length', 'width'], 'unitFields' => ['drop' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the table shape', 'text' => 'And enter its size.'],
        ['name' => 'Choose the drop', 'text' => 'How far it hangs down.'],
    ]"
    :faqs="[
        ['question' => 'What size tablecloth for a 6 ft table?', 'answer' => 'A 72 × 36 in table with an 8 in drop needs 52 × 88 in; the nearest standard size is 60 × 102 in.'],
        ['question' => 'What size for a 48 in round table?', 'answer' => '64 in round with an 8 in drop, so buy 70 in.'],
        ['question' => 'How long should a tablecloth hang?', 'answer' => '6–8 in for everyday, 10–15 in for formal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="shape" label="Table" :options="['rect' => 'Rectangle', 'square' => 'Square', 'oval' => 'Oval', 'round' => 'Round']" selected="rect" />
        <x-calc.field name="drop" label="Drop" value="8" min="0" placeholder="Drop">
            <label for="calc-drop-unit" class="sr-only">Drop unit</label>
            <select id="calc-drop-unit" name="drop-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Table length (or diameter)" value="72" min="0" placeholder="Table length (or diameter)">
            <label for="calc-length-unit" class="sr-only">Table length (or diameter) unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Table width" value="36" min="0" placeholder="Table width">
            <label for="calc-width-unit" class="sr-only">Table width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Tablecloth size" />

    <x-calc.options :decimals="false" :examples="[
        '72 × 36 in table' => ['shape' => 'rect', 'drop' => 8, 'drop-unit' => 'in', 'length' => 72, 'length-unit' => 'in', 'width' => 36, 'width-unit' => 'in'],
        '48 in round' => ['shape' => 'round', 'drop' => 8, 'drop-unit' => 'in', 'length' => 48, 'length-unit' => 'in', 'width' => '', 'width-unit' => 'in'],
        'Floor length 6 ft banquet' => ['shape' => 'rect', 'drop' => 29, 'drop-unit' => 'in', 'length' => 72, 'length-unit' => 'in', 'width' => 30, 'width-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'metric' => ['label' => 'Metric'],
            'standard' => ['label' => 'Standard size'],
            'drops' => ['label' => 'Drop guide'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size = table + 2 × drop</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
