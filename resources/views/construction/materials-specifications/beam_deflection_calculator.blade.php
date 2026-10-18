<x-calc.page
    title="Beam Deflection Calculator - SolveKit"
    description="Free beam deflection calculator: maximum deflection, span ratio, moment and bending stress of simply supported and cantilever beams with point or uniform loads."
    lede="Work out how far a beam bends under load."
    about="Elastic beam formulas (Roark): simply supported with a center load δ = PL³ ÷ 48EI or a uniform load 5wL⁴ ÷ 384EI; cantilever with an end load PL³ ÷ 3EI or a uniform load wL⁴ ÷ 8EI. Wood moduli are Wood Handbook mean values for clear wood at 12% moisture; graded lumber design values (NDS) are lower, so this is for checking stiffness, not for sizing a structural member, which needs an engineer."
    :calc="['engine' => 'con-mech', 'tool' => 'beam_deflection', 'fields' => ['load_case', 'span', 'limit', 'point', 'uniform', 'w_units', 'section', 'b', 'h', 'd', 't', 'tf', 'tw', 'inertia', 'depth', 'material', 'e'], 'unitFields' => ['span' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'point' => collect(config('units.force'))->only(['lbf', 'n', 'kn', 'kip'])->all(), 'b' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'h' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'd' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 't' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'tf' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'tw' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['wood' => config('construction_data.wood')]]"
    :how-to="[
        ['name' => 'Choose the beam and load', 'text' => 'Supported both ends or a cantilever.'],
        ['name' => 'Enter the span, load and section', 'text' => 'In any units.'],
        ['name' => 'Choose the material', 'text' => 'Or enter E.'],
    ]"
    :faqs="[
        ['question' => 'What is L/360?', 'answer' => 'A deflection of span ÷ 360, the usual limit for floors under live load.'],
        ['question' => 'How much does a 2×10 sag over 12 ft?', 'answer' => 'With 100 lb/ft and Douglas-fir clear-wood E: about 0.24 in (L/593).'],
        ['question' => 'Can I size a joist with this?', 'answer' => 'Use it to check stiffness; sizing needs graded design values and the AWC span tables or an engineer.'],
    ]"
>
    <x-calc.select name="load_case" label="Beam and load" :options="['ss_point' => 'Simply supported, center load', 'ss_uniform' => 'Simply supported, uniform load', 'cant_point' => 'Cantilever, end load', 'cant_uniform' => 'Cantilever, uniform load']" selected="ss_uniform" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="span" label="Span" value="12" min="0" placeholder="Span">
            <label for="calc-span-unit" class="sr-only">Span unit</label>
            <select id="calc-span-unit" name="span-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="limit" label="Deflection limit" :options="['240' => 'L/240', '360' => 'L/360', '480' => 'L/480']" selected="360" />
    </div>

    <div data-show-when="load_case:ss_point,cant_point" hidden>
        <x-calc.field name="point" label="Point load" value="500" min="0" placeholder="Point load">
            <label for="calc-point-unit" class="sr-only">Point load unit</label>
            <select id="calc-point-unit" name="point-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.force'))->only(['lbf', 'n', 'kn', 'kip']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lbf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="load_case:ss_uniform,cant_uniform">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="uniform" label="Uniform load" value="100" min="0" />
            <x-calc.select name="w_units" label="Per" :options="['lbft' => 'lb/ft', 'knm' => 'kN/m']" selected="lbft" />
        </div>
    </div>

    <x-calc.select name="section" label="Section" :options="['rectangle' => 'Rectangle (solid)', 'round' => 'Round bar', 'tube' => 'Round tube', 'rect_tube' => 'Rectangular tube', 'i_beam' => 'I-beam (b, h, tf, tw)', 'custom' => 'My I and depth']" selected="rectangle" />

    <div data-show-when="section:rectangle,rect_tube,i_beam">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="b" label="Width b" value="3.5" min="0" placeholder="Width b">
                <label for="calc-b-unit" class="sr-only">Width b unit</label>
                <select id="calc-b-unit" name="b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="h" label="Depth h" value="9.25" min="0" placeholder="Depth h">
                <label for="calc-h-unit" class="sr-only">Depth h unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="section:round,tube" hidden>
        <x-calc.field name="d" label="Diameter" value="2" min="0" placeholder="Diameter">
            <label for="calc-d-unit" class="sr-only">Diameter unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="section:tube,rect_tube" hidden>
        <x-calc.field name="t" label="Wall thickness" value="0.25" min="0" placeholder="Wall thickness">
            <label for="calc-t-unit" class="sr-only">Wall thickness unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div data-show-when="section:i_beam" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="tf" label="Flange thickness tf" value="0.435" min="0" placeholder="Flange thickness tf">
                <label for="calc-tf-unit" class="sr-only">Flange thickness tf unit</label>
                <select id="calc-tf-unit" name="tf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="tw" label="Web thickness tw" value="0.285" min="0" placeholder="Web thickness tw">
                <label for="calc-tw-unit" class="sr-only">Web thickness tw unit</label>
                <select id="calc-tw-unit" name="tw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="section:custom" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="inertia" label="Moment of inertia I" value="100" min="0" suffix="in⁴" />
            <x-calc.field name="depth" label="Section depth" value="8" min="0" placeholder="Section depth">
                <label for="calc-depth-unit" class="sr-only">Section depth unit</label>
                <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="material" label="Material" :options="['steel' => 'Steel (E = 29,000 ksi)', 'aluminum' => 'Aluminum 6061 (E = 10,000 ksi)'] + collect(config('construction_data.wood'))->mapWithKeys(fn ($w, $k) => ['wood:'.$k => $w['name'].' (clear wood, '.$w['e_12'].' MPa)'])->all() + ['custom' => 'My modulus']" selected="wood:douglas_fir" />
        <div data-show-when="material:custom" hidden>
            <x-calc.field name="e" label="Modulus E" value="200" min="0" suffix="GPa" />
        </div>
    </div>

    <x-calc.result label="Maximum deflection" />

    <x-calc.options :examples="[
        '2×10 Douglas-fir, 12 ft, 100 lb/ft' => ['load_case' => 'ss_uniform', 'span' => 12, 'span-unit' => 'ft', 'limit' => '360', 'uniform' => 100, 'w_units' => 'lbft', 'section' => 'rectangle', 'b' => 1.5, 'b-unit' => 'in', 'h' => 9.25, 'h-unit' => 'in', 'material' => 'wood:douglas_fir'],
        'Steel W8 (I-beam) 16 ft, 2,000 lb' => ['load_case' => 'ss_point', 'span' => 16, 'span-unit' => 'ft', 'limit' => '360', 'point' => 2000, 'point-unit' => 'lbf', 'section' => 'i_beam', 'b' => 8, 'b-unit' => 'in', 'h' => 8, 'h-unit' => 'in', 'tf' => 0.435, 'tf-unit' => 'in', 'tw' => 0.285, 'tw-unit' => 'in', 'material' => 'steel'],
        'Aluminum tube cantilever' => ['load_case' => 'cant_point', 'span' => 1, 'span-unit' => 'm', 'limit' => '240', 'point' => 200, 'point-unit' => 'n', 'section' => 'tube', 'd' => 50, 'd-unit' => 'mm', 't' => 3, 't-unit' => 'mm', 'material' => 'aluminum'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Deflected shape" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'ratio' => ['label' => 'Span ratio'],
            'moment' => ['label' => 'Maximum moment'],
            'stress' => ['label' => 'Bending stress'],
            'shear' => ['label' => 'Maximum shear'],
            'section' => ['label' => 'Section'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SS center: δ = PL³ ÷ 48EI, M = PL ÷ 4</li>
            <li>SS uniform: δ = 5wL⁴ ÷ 384EI, M = wL² ÷ 8</li>
            <li>cantilever end: δ = PL³ ÷ 3EI; uniform: wL⁴ ÷ 8EI</li>
            <li>σ = M c ÷ I</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
