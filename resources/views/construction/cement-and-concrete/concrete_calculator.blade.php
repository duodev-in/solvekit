<x-calc.page
    title="Concrete Calculator - SolveKit"
    description="Free concrete calculator: cubic yards, cubic meters and premix bags for slabs of any shape, walls, footings, columns, steps and curbs."
    lede="Work out how much concrete you need for a slab, wall, footing, column, steps or curb."
    about="The volume comes from the exact geometry of what you pour, plus an allowance for waste and uneven subgrade (5–10% is common). Ready-mix is ordered by the cubic yard or cubic meter; premix bags list their yield, 0.60 ft³ for an 80 lb bag."
    :calc="['engine' => 'con-concrete', 'tool' => 'concrete', 'fields' => ['form', 'shape', 'length', 'width', 'diameter', 'base', 'side_a', 'side_b', 'height', 'cut_length', 'cut_width', 'outer', 'inner', 'thickness', 'run', 'section_width', 'section_depth', 'round_diameter', 'round_height', 'steps', 'stair_width', 'rise', 'run_depth', 'landing', 'curb_depth', 'curb_height', 'gutter_width', 'flag', 'count', 'waste', 'price'], 'unitFields' => ['length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'base' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_a' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'side_b' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'cut_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'outer' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'inner' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'thickness' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'run' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'section_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'section_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'round_diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'round_height' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'stair_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'rise' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'run_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'landing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'curb_depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'curb_height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'gutter_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'flag' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['bags' => config('construction_data.bags')]]"
    :how-to="[
        ['name' => 'Choose the pour', 'text' => 'Slab, wall, footing, column, steps or curb.'],
        ['name' => 'Enter the sizes', 'text' => 'In any units.'],
        ['name' => 'Add waste', 'text' => '5–10% for spillage and uneven ground.'],
    ]"
    :faqs="[
        ['question' => 'How much concrete for a 10 × 10 slab?', 'answer' => 'At 4 in thick: 1.23 yd³, or about 56 bags of 80 lb.'],
        ['question' => 'How many 80 lb bags make a yard?', 'answer' => '45 bags (27 ÷ 0.6).'],
        ['question' => 'How thick should a patio slab be?', 'answer' => '4 in for patios and walks, 5–6 in for driveways and garage floors.'],
    ]"
>
    <x-calc.select name="form" label="Pour" :options="['slab' => 'Slab, patio or pad', 'wall' => 'Wall', 'footing' => 'Footing (continuous)', 'round' => 'Round column or tube', 'stairs' => 'Steps', 'curb' => 'Curb and gutter']" selected="slab" />

    <div data-show-when="form:slab">
        <div class="flex flex-col gap-3">
            <x-calc.shape :shapes="['rectangle', 'circle', 'triangle', 'trapezoid', 'l_shape', 'ring', 'oval']" selected="rectangle" />
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div data-show-when="shape:rectangle,l_shape,oval">
                    <x-calc.field name="length" label="Length" value="12" min="0" placeholder="Length">
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

    <div data-show-when="form:slab">
        <x-calc.field name="thickness" label="Thickness" value="4" min="0" placeholder="Thickness">
            <label for="calc-thickness-unit" class="sr-only">Thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="form:wall,footing,curb" hidden>
        <x-calc.field name="run" label="Length" value="40" min="0" placeholder="Length">
            <label for="calc-run-unit" class="sr-only">Length unit</label>
            <select id="calc-run-unit" name="run-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="form:wall,footing" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="section_width" label="Width or thickness" value="8" min="0" placeholder="Width or thickness">
                <label for="calc-section_width-unit" class="sr-only">Width or thickness unit</label>
                <select id="calc-section_width-unit" name="section_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="section_depth" label="Height or depth" value="48" min="0" placeholder="Height or depth">
                <label for="calc-section_depth-unit" class="sr-only">Height or depth unit</label>
                <select id="calc-section_depth-unit" name="section_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="form:round" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="round_diameter" label="Diameter" value="12" min="0" placeholder="Diameter">
                <label for="calc-round_diameter-unit" class="sr-only">Diameter unit</label>
                <select id="calc-round_diameter-unit" name="round_diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="round_height" label="Height" value="4" min="0" placeholder="Height">
                <label for="calc-round_height-unit" class="sr-only">Height unit</label>
                <select id="calc-round_height-unit" name="round_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="form:stairs" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="steps" label="Number of steps" value="3" min="1" step="1" />
            <x-calc.field name="stair_width" label="Width" value="48" min="0" placeholder="Width">
                <label for="calc-stair_width-unit" class="sr-only">Width unit</label>
                <select id="calc-stair_width-unit" name="stair_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="form:stairs" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="rise" label="Rise per step" value="7" min="0" placeholder="Rise per step">
                <label for="calc-rise-unit" class="sr-only">Rise per step unit</label>
                <select id="calc-rise-unit" name="rise-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="run_depth" label="Run per step" value="11" min="0" placeholder="Run per step">
                <label for="calc-run_depth-unit" class="sr-only">Run per step unit</label>
                <select id="calc-run_depth-unit" name="run_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="landing" label="Top landing (optional)" value="" min="0" placeholder="Top landing (optional)">
                <label for="calc-landing-unit" class="sr-only">Top landing (optional) unit</label>
                <select id="calc-landing-unit" name="landing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="form:curb" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="curb_depth" label="Curb depth" value="6" min="0" placeholder="Curb depth">
                <label for="calc-curb_depth-unit" class="sr-only">Curb depth unit</label>
                <select id="calc-curb_depth-unit" name="curb_depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="curb_height" label="Curb height" value="6" min="0" placeholder="Curb height">
                <label for="calc-curb_height-unit" class="sr-only">Curb height unit</label>
                <select id="calc-curb_height-unit" name="curb_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="form:curb" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="gutter_width" label="Gutter width" value="18" min="0" placeholder="Gutter width">
                <label for="calc-gutter_width-unit" class="sr-only">Gutter width unit</label>
                <select id="calc-gutter_width-unit" name="gutter_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="flag" label="Gutter (flag) thickness" value="6" min="0" placeholder="Gutter (flag) thickness">
                <label for="calc-flag-unit" class="sr-only">Gutter (flag) thickness unit</label>
                <select id="calc-flag-unit" name="flag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="count" label="How many" value="1" min="1" step="1" />
        <x-calc.field name="waste" label="Extra for waste" value="5" min="0" max="100" suffix="%" />
        <x-calc.field name="price" label="Price per yd³ (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Concrete needed" />

    <x-calc.options :examples="[
        'Patio 12 × 10 ft, 4 in' => ['form' => 'slab', 'shape' => 'rectangle', 'length' => 12, 'width' => 10, 'length-unit' => 'ft', 'width-unit' => 'ft', 'thickness' => 4, 'thickness-unit' => 'in', 'count' => 1, 'waste' => 5],
        'Footing 40 ft, 16 × 8 in' => ['form' => 'footing', 'run' => 40, 'run-unit' => 'ft', 'section_width' => 16, 'section_width-unit' => 'in', 'section_depth' => 8, 'section_depth-unit' => 'in', 'count' => 1, 'waste' => 5],
        'Three steps 4 ft wide' => ['form' => 'stairs', 'steps' => 3, 'stair_width' => 48, 'stair_width-unit' => 'in', 'rise' => 7, 'rise-unit' => 'in', 'run_depth' => 11, 'run_depth-unit' => 'in', 'count' => 1, 'waste' => 5],
        'Round pad 3 m, 100 mm' => ['form' => 'slab', 'shape' => 'circle', 'diameter' => 3, 'diameter-unit' => 'm', 'thickness' => 100, 'thickness-unit' => 'mm', 'count' => 1, 'waste' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm3' => ['label' => 'Cubic meters'],
            'ft3' => ['label' => 'Cubic feet'],
            'bags_80' => ['label' => '80 lb bags'],
            'bags_60' => ['label' => '60 lb bags'],
            'bags_50' => ['label' => '50 lb bags'],
            'bags_40' => ['label' => '40 lb bags'],
            'weight' => ['label' => 'Weight'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>slab: area × thickness</li>
            <li>steps: W × R × T × n(n + 1) ÷ 2 (+ landing)</li>
            <li>curb: L × (curb depth × (curb height + flag) + gutter width × flag)</li>
            <li>1 yd³ = 27 ft³ = 0.7646 m³</li>
            <li>premix yields: 80 lb = 0.60 ft³, 60 lb = 0.45 ft³, 40 lb = 0.30 ft³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
