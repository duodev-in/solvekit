<x-calc.page
    title="Epoxy Calculator - SolveKit"
    description="Free epoxy calculator: epoxy resin volume for a coating or a mold (river table, casting), split into resin and hardener by ratio."
    lede="Work out how much epoxy resin and hardener to mix."
    about="For a coating, volume = area × thickness; for a pour, the inside volume of the mold. Split the total by the maker's mix ratio, by volume or by weight. Seal-coat porous wood first and mix a little extra (5–10%) for what stays in the cup."
    :calc="['engine' => 'con-finish', 'tool' => 'epoxy', 'fields' => ['mode', 'shape', 'length', 'width', 'diameter', 'base', 'side_a', 'side_b', 'height', 'cut_length', 'cut_width', 'outer', 'inner', 'thickness', 'mold_length', 'mold_width', 'mold_depth', 'ratio', 'basis', 'waste', 'part_a', 'part_b', 'density'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_a' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_b' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'outer' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'inner' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'mold_length' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'mold_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'mold_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'density' => collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3'])->all()]]"
    :how-to="[
        ['name' => 'Choose coating or pour', 'text' => 'And enter the sizes.'],
        ['name' => 'Enter the mix ratio', 'text' => 'From the product, by volume or weight.'],
    ]"
    :faqs="[
        ['question' => 'How much epoxy for a 6 × 3 ft tabletop?', 'answer' => 'About 1.4 gal at ⅛ in thick.'],
        ['question' => 'How thick can I pour?', 'answer' => 'Coating epoxy is usually poured ⅛–¼ in per layer; deep-pour resins allow 1–2 in.'],
        ['question' => 'Is 1 : 1 by volume the same as by weight?', 'answer' => 'Not exactly; use whichever the maker states.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Job" :options="['coat' => 'Coating (tabletop, floor)', 'mold' => 'Pour into a mold']" selected="coat" />

    <div data-show-when="mode:coat">
        <div class="flex flex-col gap-3">
            <x-calc.shape :shapes="['rectangle', 'circle', 'triangle', 'trapezoid', 'l_shape', 'ring', 'oval']" selected="rectangle" />
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div data-show-when="shape:rectangle,l_shape,oval">
                    <x-calc.field name="length" label="Length" value="6" min="0" placeholder="Length">
                        <label for="calc-length-unit" class="sr-only">Length unit</label>
                        <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                            @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                                <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                            @endforeach
                        </select>
                    </x-calc.field>
                </div>
                <div data-show-when="shape:rectangle,l_shape,oval">
                    <x-calc.field name="width" label="Width" value="3" min="0" placeholder="Width">
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

    <div data-show-when="mode:coat">
        <x-calc.field name="thickness" label="Coat thickness" value="0.125" min="0" placeholder="Coat thickness">
            <label for="calc-thickness-unit" class="sr-only">Coat thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="mode:mold" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="mold_length" label="Length" value="72" min="0" placeholder="Length">
                <label for="calc-mold_length-unit" class="sr-only">Length unit</label>
                <select id="calc-mold_length-unit" name="mold_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="mold_width" label="Width (river)" value="8" min="0" placeholder="Width (river)">
                <label for="calc-mold_width-unit" class="sr-only">Width (river) unit</label>
                <select id="calc-mold_width-unit" name="mold_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="mold_depth" label="Depth" value="1.5" min="0" placeholder="Depth">
                <label for="calc-mold_depth-unit" class="sr-only">Depth unit</label>
                <select id="calc-mold_depth-unit" name="mold_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="ratio" label="Mix ratio A : B" :options="['1:1' => '1 : 1', '2:1' => '2 : 1', '3:1' => '3 : 1', '100:45' => '100 : 45', 'custom' => 'Other']" selected="1:1" />
        <x-calc.segmented name="basis" legend="Ratio by" :options="['volume' => 'Volume', 'weight' => 'Weight']" selected="volume" />
        <x-calc.field name="waste" label="Extra" value="10" min="0" max="100" suffix="%" />
    </div>

    <div data-show-when="ratio:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="part_a" label="Part A" value="100" min="0" />
            <x-calc.field name="part_b" label="Part B" value="40" min="0" />
        </div>
    </div>

    <x-calc.field name="density" label="Mixed density (optional)" value="" min="0" placeholder="From the data sheet">
        <label for="calc-density-unit" class="sr-only">Mixed density (optional) unit</label>
        <select id="calc-density-unit" name="density-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.density'))->only(['lbft3', 'kgm3', 'gcm3']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'gcm3')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Epoxy needed" />

    <x-calc.options :examples="[
        'Tabletop 6 × 3 ft, ⅛ in' => ['mode' => 'coat', 'shape' => 'rectangle', 'length' => 6, 'width' => 3, 'length-unit' => 'ft', 'width-unit' => 'ft', 'thickness' => 0.125, 'thickness-unit' => 'in', 'ratio' => '1:1', 'basis' => 'volume', 'waste' => 10],
        'River table 72 × 8 × 1.5 in' => ['mode' => 'mold', 'mold_length' => 72, 'mold_length-unit' => 'in', 'mold_width' => 8, 'mold_width-unit' => 'in', 'mold_depth' => 1.5, 'mold_depth-unit' => 'in', 'ratio' => '2:1', 'basis' => 'volume', 'waste' => 10],
        'Round 24 in, by weight' => ['mode' => 'coat', 'shape' => 'circle', 'diameter' => 24, 'diameter-unit' => 'in', 'thickness' => 3, 'thickness-unit' => 'mm', 'ratio' => '100:45', 'basis' => 'weight', 'waste' => 10, 'density' => 1.1, 'density-unit' => 'gcm3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'a' => ['label' => 'Part A'],
            'b' => ['label' => 'Part B'],
            'total' => ['label' => 'Total weight'],
            'liters' => ['label' => 'Liters'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = area × thickness, or mold L × W × D</li>
            <li>part A = total × A ÷ (A + B)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
