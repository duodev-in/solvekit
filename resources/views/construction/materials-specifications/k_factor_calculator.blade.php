<x-calc.page
    title="K-Factor Calculator - SolveKit"
    description="Free K-factor calculator: sheet metal K-factor from a test bend, or bend allowance, bend deduction and flat length from a K-factor."
    lede="Work out the K-factor, bend allowance and bend deduction for sheet metal."
    about="The neutral axis sits K × thickness from the inside of a bend. Bend allowance BA = θ × (R + K t) (θ in radians); outside setback OSSB = tan(θ ÷ 2) × (R + t); bend deduction BD = 2 OSSB − BA. From a test piece, BD = flange A + flange B − flat length gives the K-factor back."
    :calc="['engine' => 'con-mech', 'tool' => 'k_factor', 'fields' => ['mode', 'thickness', 'radius', 'angle', 'leg_a', 'leg_b', 'flat', 'k'], 'unitFields' => ['thickness' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'radius' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'leg_a' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'leg_b' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'flat' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Bend a test piece', 'text' => 'Measure its outside flanges and its flat blank.'],
        ['name' => 'Or enter a K-factor', 'text' => 'To get the allowance and deduction.'],
    ]"
    :faqs="[
        ['question' => 'What is a typical K-factor?', 'answer' => 'About 0.3–0.5; air-bent steel with R ≈ t is often near 0.44.'],
        ['question' => 'What is bend deduction?', 'answer' => 'How much shorter the flat blank is than the sum of the outside flanges.'],
        ['question' => 'Why measure a test bend?', 'answer' => 'K depends on the material, tooling and method, so a test gives the real value.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['measure' => 'K from a test bend', 'use' => 'Bend values from K']" selected="measure" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="thickness" label="Thickness" value="0.0625" min="0" placeholder="Thickness">
            <label for="calc-thickness-unit" class="sr-only">Thickness unit</label>
            <select id="calc-thickness-unit" name="thickness-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="radius" label="Inside radius" value="0.0625" min="0" placeholder="Inside radius">
            <label for="calc-radius-unit" class="sr-only">Inside radius unit</label>
            <select id="calc-radius-unit" name="radius-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="angle" label="Bend angle" value="90" min="1" max="179" suffix="°" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="leg_a" label="Outside flange A" value="1" min="0" placeholder="Outside flange A">
            <label for="calc-leg_a-unit" class="sr-only">Outside flange A unit</label>
            <select id="calc-leg_a-unit" name="leg_a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="leg_b" label="Outside flange B" value="1" min="0" placeholder="Outside flange B">
            <label for="calc-leg_b-unit" class="sr-only">Outside flange B unit</label>
            <select id="calc-leg_b-unit" name="leg_b-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:measure">
            <x-calc.field name="flat" label="Measured flat length" value="1.8825" min="0" placeholder="Measured flat length">
                <label for="calc-flat-unit" class="sr-only">Measured flat length unit</label>
                <select id="calc-flat-unit" name="flat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:use" hidden>
        <x-calc.field name="k" label="K-factor" value="0.44" min="0" max="1" step="0.01" />
    </div>

    <x-calc.result label="K-factor" />

    <x-calc.options :examples="[
        '16 ga test bend' => ['mode' => 'measure', 'thickness' => 0.0625, 'thickness-unit' => 'in', 'radius' => 0.0625, 'radius-unit' => 'in', 'angle' => 90, 'leg_a' => 1, 'leg_a-unit' => 'in', 'leg_b' => 1, 'leg_b-unit' => 'in', 'flat' => 1.8825, 'flat-unit' => 'in'],
        'K = 0.44, 2 mm at 90°' => ['mode' => 'use', 'thickness' => 2, 'thickness-unit' => 'mm', 'radius' => 2, 'radius-unit' => 'mm', 'angle' => 90, 'leg_a' => 50, 'leg_a-unit' => 'mm', 'leg_b' => 30, 'leg_b-unit' => 'mm', 'k' => 0.44],
        'Aluminum 135°' => ['mode' => 'use', 'thickness' => 0.125, 'thickness-unit' => 'in', 'radius' => 0.188, 'radius-unit' => 'in', 'angle' => 135, 'leg_a' => 2, 'leg_a-unit' => 'in', 'leg_b' => 1.5, 'leg_b-unit' => 'in', 'k' => 0.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ba' => ['label' => 'Bend allowance'],
            'bd' => ['label' => 'Bend deduction'],
            'ossb' => ['label' => 'Outside setback'],
            'flat' => ['label' => 'Flat length'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>BA = θ (R + K t)</li>
            <li>OSSB = tan(θ ÷ 2)(R + t)</li>
            <li>BD = 2 OSSB − BA</li>
            <li>K = (BA ÷ θ − R) ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
