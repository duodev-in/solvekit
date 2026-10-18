<x-calc.page
    title="Road Base Calculator - SolveKit"
    description="Free road base calculator: tons of road base or crushed aggregate base for a compacted depth, with a compaction allowance."
    lede="Work out how much road base to order for a compacted depth."
    about="Road base is delivered loose and compacted in place, so you order more loose volume than the finished layer: loose = compacted × (1 + compaction allowance). Allowances of 15–25% are common for crushed base; your supplier can confirm the figure for their material."
    :calc="['engine' => 'con-bulk', 'tool' => 'road_base', 'fields' => ['input', 'shape', 'length', 'width', 'diameter', 'base', 'side_a', 'side_b', 'height', 'cut_length', 'cut_width', 'outer', 'inner', 'area', 'depth', 'compaction', 'material', 'density', 'price', 'price_basis'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_a' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_b' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'outer' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'inner' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all()], 'data' => ['products' => config('construction_data.products'), 'bulk' => config('construction_data.bulk')]]"
    :how-to="[
        ['name' => 'Measure the area', 'text' => 'Pick a shape or enter the area.'],
        ['name' => 'Enter the compacted depth', 'text' => 'And the compaction allowance.'],
    ]"
    :faqs="[
        ['question' => 'How much extra road base for compaction?', 'answer' => 'Usually 15–25% more loose material than the compacted volume.'],
        ['question' => 'How deep should road base be?', 'answer' => '4–6 in for paths and patios, 6–8 in or more for driveways.'],
        ['question' => 'What is road base?', 'answer' => 'Crushed stone with fines (such as crusher run or ABC) that locks together when compacted.'],
    ]"
>
    <x-calc.segmented name="input" legend="Measure by" :options="['shape' => 'Shape', 'area' => 'Known area']" selected="shape" />

    <div data-show-when="input:shape">
        <div class="flex flex-col gap-3">
            <x-calc.shape :shapes="['rectangle', 'circle', 'triangle', 'trapezoid', 'l_shape', 'ring', 'oval']" selected="rectangle" />
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div data-show-when="shape:rectangle,l_shape,oval">
                    <x-calc.field name="length" label="Length" value="20" min="0" placeholder="Length">
                        <label for="calc-length-unit" class="sr-only">Length unit</label>
                        <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:rectangle,l_shape,oval">
                    <x-calc.field name="width" label="Width" value="10" min="0" placeholder="Width">
                        <label for="calc-width-unit" class="sr-only">Width unit</label>
                        <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:circle" hidden>
                    <x-calc.field name="diameter" label="Diameter" value="10" min="0" placeholder="Diameter">
                        <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
                        <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:triangle" hidden>
                    <x-calc.field name="base" label="Base" value="12" min="0" placeholder="Base">
                        <label for="calc-base-unit" class="sr-only">Base unit</label>
                        <select id="calc-base-unit" name="base-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:trapezoid" hidden>
                    <x-calc.field name="side_a" label="Top side a" value="8" min="0" placeholder="Top side a">
                        <label for="calc-side_a-unit" class="sr-only">Top side a unit</label>
                        <select id="calc-side_a-unit" name="side_a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:trapezoid" hidden>
                    <x-calc.field name="side_b" label="Bottom side b" value="14" min="0" placeholder="Bottom side b">
                        <label for="calc-side_b-unit" class="sr-only">Bottom side b unit</label>
                        <select id="calc-side_b-unit" name="side_b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:triangle,trapezoid" hidden>
                    <x-calc.field name="height" label="Height" value="10" min="0" placeholder="Height">
                        <label for="calc-height-unit" class="sr-only">Height unit</label>
                        <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:l_shape" hidden>
                    <x-calc.field name="cut_length" label="Cut-out length" value="8" min="0" placeholder="Cut-out length">
                        <label for="calc-cut_length-unit" class="sr-only">Cut-out length unit</label>
                        <select id="calc-cut_length-unit" name="cut_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:l_shape" hidden>
                    <x-calc.field name="cut_width" label="Cut-out width" value="4" min="0" placeholder="Cut-out width">
                        <label for="calc-cut_width-unit" class="sr-only">Cut-out width unit</label>
                        <select id="calc-cut_width-unit" name="cut_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:ring" hidden>
                    <x-calc.field name="outer" label="Outer diameter" value="12" min="0" placeholder="Outer diameter">
                        <label for="calc-outer-unit" class="sr-only">Outer diameter unit</label>
                        <select id="calc-outer-unit" name="outer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:ring" hidden>
                    <x-calc.field name="inner" label="Inner diameter" value="6" min="0" placeholder="Inner diameter">
                        <label for="calc-inner-unit" class="sr-only">Inner diameter unit</label>
                        <select id="calc-inner-unit" name="inner-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
            </div>
        </div>
    </div>

    <div data-show-when="input:area" hidden>
        <x-calc.field name="area" label="Area" value="600" min="0" placeholder="Area">
            <label for="calc-area-unit" class="sr-only">Area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="depth" label="Compacted depth" value="6" min="0" placeholder="Compacted depth">
            <label for="calc-depth-unit" class="sr-only">Compacted depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="compaction" label="Compaction allowance" value="20" min="0" max="100" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="material" label="Material" :options="collect(config('construction_data.products'))->map(fn ($p) => $p['name'])->all()" selected="crushed_stone" />
        <x-calc.field name="density" label="Your loose density (optional)" value="" min="0" placeholder="Your loose density (optional)">
            <label for="calc-density-unit" class="sr-only">Your loose density (optional) unit</label>
            <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lbft3')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
        <x-calc.select name="price_basis" label="Price basis" :options="['ton' => 'per US ton', 'yd3' => 'per yd³', 't' => 'per metric ton']" selected="ton" />
    </div>

    <x-calc.result label="Base to order" />

    <x-calc.options :examples="[
        'Driveway 600 ft², 6 in' => ['input' => 'area', 'area' => 600, 'area-unit' => 'ft2', 'depth' => 6, 'depth-unit' => 'in', 'compaction' => 20, 'material' => 'crushed_stone'],
        'Yard 15 × 10 m, 150 mm' => ['input' => 'shape', 'shape' => 'rectangle', 'length' => 15, 'width' => 10, 'length-unit' => 'm', 'width-unit' => 'm', 'depth' => 150, 'depth-unit' => 'mm', 'compaction' => 20, 'material' => 'crushed_stone'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'compacted' => ['label' => 'Compaction'],
            'tonnes' => ['label' => 'Metric tons'],
            'pounds' => ['label' => 'Pounds'],
            'yd3' => ['label' => 'Cubic yards'],
            'ft3' => ['label' => 'Cubic feet'],
            'm3' => ['label' => 'Cubic meters'],
            'bags' => ['label' => 'Bags'],
            'density' => ['label' => 'Density used'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>loose volume = area × depth × (1 + allowance)</li>
            <li>tons = loose volume × loose density</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
