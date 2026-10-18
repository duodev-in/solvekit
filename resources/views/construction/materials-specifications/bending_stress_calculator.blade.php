<x-calc.page
    title="Bending Stress Calculator - SolveKit"
    description="Free bending stress calculator: σ = M c ÷ I for rectangular, round, tube and I-sections, with section modulus and safety factor."
    lede="Work out the bending stress in a beam section."
    about="The flexure formula σ = M c ÷ I = M ÷ S gives the stress at the outer fiber, where I is the second moment of area, c the distance to the outer fiber and S = I ÷ c the section modulus. It holds for linear elastic behavior."
    :calc="['engine' => 'con-mech', 'tool' => 'bending_stress', 'fields' => ['moment', 'section', 'b', 'h', 'd', 't', 'tf', 'tw', 'inertia', 'depth', 'yield'], 'unitFields' => ['moment' => collect(config('units.torque'))->only(['lbfft', 'nm', 'lbfin'])->all(), 'b' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'h' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'd' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 't' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'tf' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'tw' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'yield' => collect(config('units.pressure'))->only(['psi', 'ksi', 'mpa'])->all()]]"
    :how-to="[
        ['name' => 'Enter the moment', 'text' => 'From your load case.'],
        ['name' => 'Choose the section', 'text' => 'And its sizes.'],
    ]"
    :faqs="[
        ['question' => 'What is section modulus?', 'answer' => 'S = I ÷ c; bending stress is M ÷ S.'],
        ['question' => 'What is the bending stress in a 2×10 with 2,000 lb·ft?', 'answer' => 'About 1,120 psi (S = 21.4 in³).'],
        ['question' => 'What is the yield of A36 steel?', 'answer' => '36 ksi.'],
    ]"
>
    <x-calc.field name="moment" label="Bending moment" value="2000" min="0" placeholder="Bending moment">
        <label for="calc-moment-unit" class="sr-only">Bending moment unit</label>
        <select id="calc-moment-unit" name="moment-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.torque'))->only(['lbfft', 'nm', 'lbfin']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lbfft')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

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

    <x-calc.field name="yield" label="Yield strength (optional)" value="36" min="0" placeholder="Yield strength (optional)">
        <label for="calc-yield-unit" class="sr-only">Yield strength (optional) unit</label>
        <select id="calc-yield-unit" name="yield-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.pressure'))->only(['psi', 'ksi', 'mpa']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'ksi')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Bending stress" />

    <x-calc.options :examples="[
        '2×10, 2,000 lb·ft' => ['moment' => 2000, 'moment-unit' => 'lbfft', 'section' => 'rectangle', 'b' => 1.5, 'b-unit' => 'in', 'h' => 9.25, 'h-unit' => 'in', 'yield' => '', 'yield-unit' => 'ksi'],
        'Steel tube 3 in, 1.5 kN·m' => ['moment' => 1.5, 'moment-unit' => 'nm', 'section' => 'tube', 'd' => 3, 'd-unit' => 'in', 't' => 0.25, 't-unit' => 'in', 'yield' => 250, 'yield-unit' => 'mpa'],
        'I-beam with yield' => ['moment' => 20000, 'moment-unit' => 'lbfft', 'section' => 'i_beam', 'b' => 8, 'b-unit' => 'in', 'h' => 8, 'h-unit' => 'in', 'tf' => 0.435, 'tf-unit' => 'in', 'tw' => 0.285, 'tw-unit' => 'in', 'yield' => 50, 'yield-unit' => 'ksi'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mpa' => ['label' => 'In MPa'],
            'modulus' => ['label' => 'Section modulus'],
            'inertia' => ['label' => 'Moment of inertia'],
            'factor' => ['label' => 'Safety factor'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>σ = M c ÷ I = M ÷ S</li>
            <li>rectangle: I = b h³ ÷ 12</li>
            <li>round: I = π d⁴ ÷ 64</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
