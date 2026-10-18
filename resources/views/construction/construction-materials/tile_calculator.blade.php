<x-calc.page
    title="Tile Calculator - SolveKit"
    description="Free tile calculator: number of tiles and boxes for a floor or wall of any shape, with grout joints and waste."
    lede="Work out how many tiles and boxes you need."
    about="Each tile with its joint covers (L + j) × (W + j). Add 10% for cuts (15% for diagonal layouts or many corners) and keep a few spares for repairs."
    :calc="['engine' => 'con-finish', 'tool' => 'tile', 'fields' => ['input', 'shape', 'length', 'width', 'diameter', 'base', 'side_a', 'side_b', 'height', 'cut_length', 'cut_width', 'outer', 'inner', 'area', 'tile_length', 'tile_width', 'joint', 'waste', 'per_box', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_a' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_b' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'outer' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'inner' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'tile_length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'tile_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'joint' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the area', 'text' => 'A shape or a known area.'],
        ['name' => 'Enter the tile and joint', 'text' => 'And the waste allowance.'],
    ]"
    :faqs="[
        ['question' => 'How many 12 in tiles for 100 ft²?', 'answer' => '98 tiles with ⅛ in joints, 108 with 10% waste.'],
        ['question' => 'How much extra tile should I buy?', 'answer' => '10% for straight layouts, 15% for diagonal or herringbone.'],
        ['question' => 'Does the joint matter?', 'answer' => 'Slightly: wider joints mean fewer tiles per square foot.'],
    ]"
>
    <x-calc.segmented name="input" legend="Measure by" :options="['shape' => 'Shape', 'area' => 'Known area']" selected="shape" />

    <div data-show-when="input:shape">
        <div class="flex flex-col gap-3">
            <x-calc.shape :shapes="['rectangle', 'circle', 'triangle', 'trapezoid', 'l_shape', 'ring', 'oval']" selected="rectangle" />
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div data-show-when="shape:rectangle,l_shape,oval">
                    <x-calc.field name="length" label="Length" value="10" min="0" placeholder="Length">
                        <label for="calc-length-unit" class="sr-only">Length unit</label>
                        <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:rectangle,l_shape,oval">
                    <x-calc.field name="width" label="Width" value="8" min="0" placeholder="Width">
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
        <x-calc.field name="area" label="Area" value="80" min="0" placeholder="Area">
            <label for="calc-area-unit" class="sr-only">Area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="tile_length" label="Tile length" value="12" min="0" placeholder="Tile length">
            <label for="calc-tile_length-unit" class="sr-only">Tile length unit</label>
            <select id="calc-tile_length-unit" name="tile_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="tile_width" label="Tile width" value="12" min="0" placeholder="Tile width">
            <label for="calc-tile_width-unit" class="sr-only">Tile width unit</label>
            <select id="calc-tile_width-unit" name="tile_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="joint" label="Joint width" value="0.125" min="0" placeholder="Joint width">
            <label for="calc-joint-unit" class="sr-only">Joint width unit</label>
            <select id="calc-joint-unit" name="joint-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="waste" label="Extra for cuts" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="per_box" label="Tiles per box (optional)" value="" min="1" step="1" placeholder="Optional" />
        <x-calc.field name="price" label="Price per tile (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Tiles needed" />

    <x-calc.options :examples="[
        'Bathroom 10 × 8 ft, 12 in tile' => ['input' => 'shape', 'shape' => 'rectangle', 'length' => 10, 'width' => 8, 'length-unit' => 'ft', 'width-unit' => 'ft', 'tile_length' => 12, 'tile_length-unit' => 'in', 'tile_width' => 12, 'tile_width-unit' => 'in', 'joint' => 0.125, 'joint-unit' => 'in', 'waste' => 10, 'per_box' => 10],
        'Backsplash 30 ft², 3 × 6 in' => ['input' => 'area', 'area' => 30, 'area-unit' => 'ft2', 'tile_length' => 6, 'tile_length-unit' => 'in', 'tile_width' => 3, 'tile_width-unit' => 'in', 'joint' => 0.0625, 'joint-unit' => 'in', 'waste' => 10],
        'Floor 20 m², 600 × 600 mm' => ['input' => 'area', 'area' => 20, 'area-unit' => 'm2', 'tile_length' => 600, 'tile_length-unit' => 'mm', 'tile_width' => 600, 'tile_width-unit' => 'mm', 'joint' => 3, 'joint-unit' => 'mm', 'waste' => 10, 'per_box' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'boxes' => ['label' => 'Boxes'],
            'area' => ['label' => 'Area'],
            'per_ft2' => ['label' => 'Tiles per ft²'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tiles = area ÷ ((L + j)(W + j)) × (1 + waste)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
