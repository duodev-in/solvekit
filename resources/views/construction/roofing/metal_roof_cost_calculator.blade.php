<x-calc.page
    title="Metal Roof Cost Calculator - SolveKit"
    description="Free metal roof cost calculator: panels, screws and roof area for a gable metal roof, and the cost from your prices."
    lede="Work out the panels and cost of a metal roof."
    about="Panels run eave to ridge: each is the rafter length including the overhang, and the number per side is the eave length ÷ the panel's coverage width (often 36 in). Screws are placed at every purlin. The costs use your prices; the defaults are example figures only."
    :calc="['engine' => 'con-roof', 'tool' => 'metal_roof_cost', 'fields' => ['length', 'width', 'pitch', 'overhang', 'coverage', 'purlin', 'screws', 'price_ft', 'trim', 'screw_price', 'underlay', 'labor'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'overhang' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'coverage' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'purlin' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the building and pitch', 'text' => 'And the overhang.'],
        ['name' => 'Enter the panel and your prices', 'text' => 'From your supplier.'],
    ]"
    :faqs="[
        ['question' => 'How many metal panels for a 40 ft roof?', 'answer' => 'With 36 in coverage and 12 in overhangs: 14 per side, 28 in all.'],
        ['question' => 'How many screws per square?', 'answer' => 'Often 70–80 at 24 in purlins; check the panel maker\'s pattern.'],
        ['question' => 'Are the default prices real?', 'answer' => 'No, they are examples; enter local prices.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="length" label="Building length" value="40" min="0" placeholder="Building length">
            <label for="calc-length-unit" class="sr-only">Building length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Building width (span)" value="30" min="0" placeholder="Building width (span)">
            <label for="calc-width-unit" class="sr-only">Building width (span) unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="pitch" label="Pitch (rise per 12)" value="6" min="0" step="0.5" />
    </div>

    <x-calc.field name="overhang" label="Eave and rake overhang" value="12" min="0" placeholder="Eave and rake overhang">
        <label for="calc-overhang-unit" class="sr-only">Eave and rake overhang unit</label>
        <select id="calc-overhang-unit" name="overhang-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="coverage" label="Panel coverage width" value="36" min="0" placeholder="Panel coverage width">
            <label for="calc-coverage-unit" class="sr-only">Panel coverage width unit</label>
            <select id="calc-coverage-unit" name="coverage-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="purlin" label="Purlin spacing" value="24" min="0" placeholder="Purlin spacing">
            <label for="calc-purlin-unit" class="sr-only">Purlin spacing unit</label>
            <select id="calc-purlin-unit" name="purlin-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="screws" label="Screws per panel per purlin" value="4" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price_ft" label="Panel price per linear ft" value="3.5" min="0" step="0.01" suffix="$" />
        <x-calc.field name="trim" label="Trim per linear ft" value="4" min="0" step="0.01" suffix="$" />
        <x-calc.field name="screw_price" label="Price per screw" value="0.12" min="0" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="underlay" label="Underlayment per ft²" value="0.15" min="0" step="0.01" suffix="$" />
        <x-calc.field name="labor" label="Labor per ft² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="0" />
    </div>

    <x-calc.result label="Metal roof cost" />

    <x-calc.options :examples="[
        '40 × 30 ft, 4/12' => ['length' => 40, 'length-unit' => 'ft', 'width' => 30, 'width-unit' => 'ft', 'pitch' => 4, 'overhang' => 12, 'overhang-unit' => 'in', 'coverage' => 36, 'coverage-unit' => 'in', 'purlin' => 24, 'purlin-unit' => 'in', 'screws' => 4, 'price_ft' => 3.5, 'trim' => 4, 'screw_price' => 0.12, 'underlay' => 0.15],
        'Barn 60 × 40 ft, 3/12, with labor' => ['length' => 60, 'length-unit' => 'ft', 'width' => 40, 'width-unit' => 'ft', 'pitch' => 3, 'overhang' => 18, 'overhang-unit' => 'in', 'coverage' => 36, 'coverage-unit' => 'in', 'purlin' => 24, 'purlin-unit' => 'in', 'screws' => 4, 'price_ft' => 3.25, 'trim' => 4, 'screw_price' => 0.12, 'underlay' => 0.15, 'labor' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'panels' => ['label' => 'Panels'],
            'area' => ['label' => 'Roof area'],
            'screws' => ['label' => 'Screws'],
            'per_ft2' => ['label' => 'Per ft²'],
        ]" />
        <x-calc.quick-ref heading="Cost breakdown" name="lines" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>panel length = (W ÷ 2 + overhang) × √(1 + (pitch ÷ 12)²)</li>
            <li>panels = 2 × ⌈(L + 2o) ÷ coverage⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
