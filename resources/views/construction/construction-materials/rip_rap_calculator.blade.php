<x-calc.page
    title="Rip Rap Calculator - SolveKit"
    description="Free riprap calculator: tons of riprap for a slope or channel from the area, layer thickness, stone size D50 and rock density, with the 1.5 × D50 thickness check."
    lede="Work out the tons of riprap for a slope, bank or channel lining."
    about="Riprap is placed as a layer at least 1.5 times the median stone size D50 thick (FHWA HEC-23 guidance; also at least the largest stone, D100). Placed weight = rock density × (1 − porosity) × volume. Quarry rock is usually about 2.65 times as dense as water, and a placed layer has roughly 35–45% voids; use your quarry's figures when you have them."
    :calc="['engine' => 'con-bulk', 'tool' => 'rip_rap', 'fields' => ['input', 'shape', 'length', 'width', 'diameter', 'base', 'side_a', 'side_b', 'height', 'cut_length', 'cut_width', 'outer', 'inner', 'area', 'thickness', 'd50', 'gravity', 'porosity', 'price', 'price_basis'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_a' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_b' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'outer' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'inner' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'd50' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['products' => config('construction_data.products'), 'bulk' => config('construction_data.bulk')]]"
    :how-to="[
        ['name' => 'Measure the area', 'text' => 'Along the slope, not the plan area.'],
        ['name' => 'Enter thickness and D50', 'text' => 'The tool checks the 1.5 × D50 rule.'],
        ['name' => 'Check rock density and voids', 'text' => 'From your quarry if known.'],
    ]"
    :faqs="[
        ['question' => 'How thick should riprap be?', 'answer' => 'At least 1.5 × D50 and at least the largest stone, per FHWA HEC-23.'],
        ['question' => 'What is D50?', 'answer' => 'The stone size that half the stones by weight are smaller than.'],
        ['question' => 'How much does riprap weigh?', 'answer' => 'About 1.6 t/m³ placed (2.65 × 1000 × 0.6), or 1.35 US tons per yd³.'],
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
        <x-calc.field name="area" label="Area" value="500" min="0" placeholder="Area">
            <label for="calc-area-unit" class="sr-only">Area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="thickness" label="Layer thickness" value="18" min="0" placeholder="Layer thickness">
            <label for="calc-thickness-unit" class="sr-only">Layer thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="d50" label="Median stone size D50" value="12" min="0" placeholder="Median stone size D50">
            <label for="calc-d50-unit" class="sr-only">Median stone size D50 unit</label>
            <select id="calc-d50-unit" name="d50-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gravity" label="Rock specific gravity" value="2.65" min="1" step="0.01" />
        <x-calc.field name="porosity" label="Layer porosity (voids)" value="40" min="0" max="99" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="price" label="Price (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
        <x-calc.select name="price_basis" label="Price basis" :options="['ton' => 'per US ton', 'yd3' => 'per yd³', 't' => 'per metric ton']" selected="ton" />
    </div>

    <x-calc.result label="Riprap needed" />

    <x-calc.options :examples="[
        'Slope 500 ft², 12 in stone' => ['input' => 'area', 'area' => 500, 'area-unit' => 'ft2', 'thickness' => 18, 'thickness-unit' => 'in', 'd50' => 12, 'd50-unit' => 'in', 'gravity' => 2.65, 'porosity' => 40],
        'Channel 40 × 8 ft' => ['input' => 'shape', 'shape' => 'rectangle', 'length' => 40, 'width' => 8, 'length-unit' => 'ft', 'width-unit' => 'ft', 'thickness' => 24, 'thickness-unit' => 'in', 'd50' => 15, 'd50-unit' => 'in', 'gravity' => 2.65, 'porosity' => 40],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'check' => ['label' => 'Thickness check'],
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
            <li>thickness ≥ 1.5 × D50</li>
            <li>weight = area × thickness × SG × 1000 × (1 − n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
