<x-calc.page
    title="Roof Pitch Calculator - SolveKit"
    description="Free roof pitch calculator: convert rise and run, angle, percent slope and x/12 pitch, with the roof area and hip factors."
    lede="Convert roof pitch between x/12, degrees, percent and ratio."
    about="Pitch is the rise in inches for 12 in of run. Angle = atan(pitch ÷ 12); percent = pitch ÷ 12 × 100. The slope factor √(1 + (pitch ÷ 12)²) turns a footprint into roof area and a run into rafter length; √(2 + (pitch ÷ 12)²) does the same for hips and valleys."
    :calc="['engine' => 'con-roof', 'tool' => 'roof_pitch', 'fields' => ['mode', 'pitch', 'rise', 'run', 'angle', 'percent'], 'unitFields' => ['rise' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'run' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pitch, rise and run, angle or percent.'],
        ['name' => 'Read every form', 'text' => 'And the slope factors.'],
    ]"
    :faqs="[
        ['question' => 'What angle is a 6/12 roof?', 'answer' => '26.57°.'],
        ['question' => 'What pitch is 45°?', 'answer' => '12/12.'],
        ['question' => 'What is a low-slope roof?', 'answer' => 'Under about 3/12 (14°); asphalt shingles need at least 2/12 (IRC R905.2.2).'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['pitch' => 'x/12', 'rise_run' => 'Rise and run', 'angle' => 'Angle', 'percent' => 'Percent']" selected="pitch" />

    <div data-show-when="mode:pitch">
        <x-calc.field name="pitch" label="Pitch (rise per 12)" value="6" min="0" step="0.5" />
    </div>

    <div data-show-when="mode:rise_run" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="rise" label="Rise" value="5" min="0" placeholder="Rise">
                <label for="calc-rise-unit" class="sr-only">Rise unit</label>
                <select id="calc-rise-unit" name="rise-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="run" label="Run" value="12" min="0" placeholder="Run">
                <label for="calc-run-unit" class="sr-only">Run unit</label>
                <select id="calc-run-unit" name="run-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:angle" hidden>
        <x-calc.field name="angle" label="Angle" value="26.57" min="0" max="89.9" suffix="°" />
    </div>

    <div data-show-when="mode:percent" hidden>
        <x-calc.field name="percent" label="Slope" value="50" min="0" suffix="%" />
    </div>

    <x-calc.result label="Roof pitch" />

    <x-calc.options :examples="[
        '6/12' => ['mode' => 'pitch', 'pitch' => 6],
        'Rise 5 in over 12 in' => ['mode' => 'rise_run', 'rise' => 5, 'rise-unit' => 'in', 'run' => 12, 'run-unit' => 'in'],
        '30°' => ['mode' => 'angle', 'angle' => 30],
        '25% slope' => ['mode' => 'percent', 'percent' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'angle' => ['label' => 'Angle'],
            'percent' => ['label' => 'Percent'],
            'ratio' => ['label' => 'Ratio'],
            'factor' => ['label' => 'Slope factor'],
            'hip' => ['label' => 'Hip factor'],
        ]" />
        <x-calc.quick-ref heading="Common pitches" name="pitches" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>angle = atan(pitch ÷ 12)</li>
            <li>slope factor = √(1 + (pitch ÷ 12)²)</li>
            <li>hip factor = √(2 + (pitch ÷ 12)²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
