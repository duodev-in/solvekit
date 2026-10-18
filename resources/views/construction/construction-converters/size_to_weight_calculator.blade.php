<x-calc.page
    title="Size to Weight Calculator (Rectangular Box) - SolveKit"
    description="Free size to weight calculator: weight of a rectangular block or box of steel, aluminum, wood, stone, concrete or glass from its length, width and height."
    lede="Work out the weight of a rectangular block from its size and material."
    about="Weight = length × width × height × density. Choose from metals (association and standard densities), woods at 12% moisture (USDA Wood Handbook), stone and concrete (ASCE 7) and glass, or enter any density."
    :calc="['engine' => 'con-weight', 'tool' => 'size_to_weight', 'fields' => ['length', 'width', 'height', 'material', 'count', 'density'], 'unitFields' => ['length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all()], 'data' => collect(config('construction_data'))->only(['metals', 'wood', 'stone', 'concrete', 'glass'])->all()]"
    :how-to="[
        ['name' => 'Enter the three sizes', 'text' => 'In any unit.'],
        ['name' => 'Choose the material', 'text' => 'Or enter its density.'],
    ]"
    :faqs="[
        ['question' => 'How do I find weight from size?', 'answer' => 'Multiply the volume by the density.'],
        ['question' => 'How much does a cubic foot of steel weigh?', 'answer' => '490 lb.'],
        ['question' => 'How much does a cubic foot of oak weigh?', 'answer' => 'About 47 lb for white oak at 12% moisture.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Length" value="12" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="6" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="height" label="Height" value="2" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="material" label="Material" :options="['Metals' => collect(config('construction_data.metals'))->mapWithKeys(fn ($m, $k) => ['metal:'.$k => $m['name']])->all(), 'Wood (12% moisture)' => collect(config('construction_data.wood'))->mapWithKeys(fn ($w, $k) => ['wood:'.$k => $w['name']])->all(), 'Stone' => collect(config('construction_data.stone'))->mapWithKeys(fn ($s, $k) => ['stone:'.$k => $s['name']])->all(), 'Concrete' => collect(config('construction_data.concrete'))->mapWithKeys(fn ($c, $k) => ['concrete:'.$k => $c['name']])->all(), 'Glass' => collect(config('construction_data.glass'))->mapWithKeys(fn ($g, $k) => ['glass:'.$k => $g['name']])->all()]" selected="metal:steel" />
        <x-calc.field name="count" label="Pieces" value="1" min="1" step="1" />
    </div>

    <x-calc.field name="density" label="Your density (optional)" value="" min="0" placeholder="Your density (optional)">
        <label for="calc-density-unit" class="sr-only">Your density (optional) unit</label>
        <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lbft3')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Weight" />

    <x-calc.options :examples="[
        'Steel block 12 × 6 × 2 in' => ['length' => 12, 'length-unit' => 'in', 'width' => 6, 'width-unit' => 'in', 'height' => 2, 'height-unit' => 'in', 'material' => 'metal:steel', 'count' => 1],
        'Oak beam 6 × 6 in × 8 ft' => ['length' => 96, 'length-unit' => 'in', 'width' => 6, 'width-unit' => 'in', 'height' => 6, 'height-unit' => 'in', 'material' => 'wood:white_oak', 'count' => 1],
        'Concrete block 1 m³' => ['length' => 1, 'length-unit' => 'm', 'width' => 1, 'width-unit' => 'm', 'height' => 1, 'height-unit' => 'm', 'material' => 'concrete:plain_stone', 'count' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'Kilograms'],
            'piece' => ['label' => 'Each piece'],
            'volume' => ['label' => 'Volume'],
            'tons' => ['label' => 'US tons'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weight = L × W × H × density</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
