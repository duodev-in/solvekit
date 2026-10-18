<x-calc.page
    title="Gravel Driveway Calculator - SolveKit"
    description="Free gravel driveway calculator: tons of stone for each layer of a gravel driveway (base, middle and top) from its length and width."
    lede="Work out the stone for each layer of a gravel driveway."
    about="A durable gravel driveway is built in layers: large base stone (such as #3), a middle layer (such as #57) and a top layer of finer gravel with fines. Each layer is weighed loose with its Caterpillar bulk density, plus a compaction allowance."
    :calc="['engine' => 'con-bulk', 'tool' => 'gravel_driveway', 'fields' => ['length', 'width', 'base_depth', 'base_material', 'middle_depth', 'middle_material', 'top_depth', 'top_material', 'compaction', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'middle_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'top_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['products' => config('construction_data.products'), 'bulk' => config('construction_data.bulk')]]"
    :how-to="[
        ['name' => 'Enter the driveway size', 'text' => 'Length and width.'],
        ['name' => 'Set each layer', 'text' => 'Depth and material; set a depth of 0 to skip a layer.'],
    ]"
    :faqs="[
        ['question' => 'How many layers does a gravel driveway need?', 'answer' => 'Usually three: base, middle and top, 8–12 in in total.'],
        ['question' => 'How much gravel for a 100 ft driveway?', 'answer' => 'A 12 ft wide driveway with 4 + 4 + 2 in needs about 55 US tons.'],
        ['question' => 'Which top layer is best?', 'answer' => 'Crushed stone with fines packs hard; rounded pea gravel stays loose.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Length" value="100" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="12" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="base_depth" label="Base layer depth" value="4" min="0" placeholder="Base layer depth">
            <label for="calc-base_depth-unit" class="sr-only">Base layer depth unit</label>
            <select id="calc-base_depth-unit" name="base_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="base_material" label="Base material" :options="collect(config('construction_data.products'))->map(fn ($p) => $p['name'])->all()" selected="crushed_stone" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="middle_depth" label="Middle layer depth" value="4" min="0" placeholder="Middle layer depth">
            <label for="calc-middle_depth-unit" class="sr-only">Middle layer depth unit</label>
            <select id="calc-middle_depth-unit" name="middle_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="middle_material" label="Middle material" :options="collect(config('construction_data.products'))->map(fn ($p) => $p['name'])->all()" selected="crushed_stone" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="top_depth" label="Top layer depth" value="2" min="0" placeholder="Top layer depth">
            <label for="calc-top_depth-unit" class="sr-only">Top layer depth unit</label>
            <select id="calc-top_depth-unit" name="top_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="top_material" label="Top material" :options="collect(config('construction_data.products'))->map(fn ($p) => $p['name'])->all()" selected="gravel" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="compaction" label="Compaction allowance" value="15" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per US ton (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Stone for the driveway" />

    <x-calc.options :examples="[
        '100 × 12 ft, three layers' => ['length' => 100, 'width' => 12, 'length-unit' => 'ft', 'width-unit' => 'ft', 'base_depth' => 4, 'base_depth-unit' => 'in', 'middle_depth' => 4, 'middle_depth-unit' => 'in', 'top_depth' => 2, 'top_depth-unit' => 'in', 'base_material' => 'crushed_stone', 'middle_material' => 'crushed_stone', 'top_material' => 'gravel', 'compaction' => 15],
        'Top-up layer only' => ['length' => 30, 'width' => 4, 'length-unit' => 'm', 'width-unit' => 'm', 'base_depth' => 0, 'base_depth-unit' => 'mm', 'middle_depth' => 0, 'middle_depth-unit' => 'mm', 'top_depth' => 50, 'top_depth-unit' => 'mm', 'top_material' => 'gravel', 'compaction' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'yd3' => ['label' => 'Loose volume'],
            'tonnes' => ['label' => 'Metric tons'],
            'cost' => ['label' => 'Cost'],
            'area' => ['label' => 'Area'],
        ]" />
        <x-calc.quick-ref heading="Each layer" name="layers" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>layer tons = L × W × depth × (1 + allowance) × density</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
