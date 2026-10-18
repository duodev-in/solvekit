<x-calc.page
    title="Elevation Grade Calculator - SolveKit"
    description="Free elevation grade calculator: percent grade, angle and ratio from rise and run or from two elevations and the distance between them."
    lede="Work out the grade between two points."
    about="Grade % = rise ÷ horizontal run × 100. A 2% grade rises 2 ft per 100 ft, or about ¼ in per foot. The angle is atan(rise ÷ run)."
    :calc="['engine' => 'con-trig', 'tool' => 'elevation_grade', 'fields' => ['mode', 'rise', 'run', 'start', 'end', 'distance'], 'unitFields' => ['rise' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'run' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'start' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'end' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'distance' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the rise and run', 'text' => 'Or two elevations and the distance.'],
    ]"
    :faqs="[
        ['question' => 'What is a 2% grade?', 'answer' => '2 ft per 100 ft, about ¼ in per ft (1.15°).'],
        ['question' => 'How much slope away from a house?', 'answer' => 'IRC R401.3: 6 in of fall in the first 10 ft (5%).'],
        ['question' => 'What grade is a 1 : 12 ramp?', 'answer' => '8.33%.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['rise_run' => 'Rise and run', 'elevations' => 'Two elevations']" selected="rise_run" />

    <div data-show-when="mode:rise_run">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="rise" label="Rise" value="2" placeholder="Rise">
                <label for="calc-rise-unit" class="sr-only">Rise unit</label>
                <select id="calc-rise-unit" name="rise-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="run" label="Horizontal run" value="100" min="0" placeholder="Horizontal run">
                <label for="calc-run-unit" class="sr-only">Horizontal run unit</label>
                <select id="calc-run-unit" name="run-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <div data-show-when="mode:elevations" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="start" label="Start elevation" value="100" placeholder="Start elevation">
                <label for="calc-start-unit" class="sr-only">Start elevation unit</label>
                <select id="calc-start-unit" name="start-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="end" label="End elevation" value="97.5" placeholder="End elevation">
                <label for="calc-end-unit" class="sr-only">End elevation unit</label>
                <select id="calc-end-unit" name="end-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="distance" label="Horizontal distance" value="120" min="0" placeholder="Horizontal distance">
                <label for="calc-distance-unit" class="sr-only">Horizontal distance unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Grade" />

    <x-calc.options :examples="[
        '2 ft over 100 ft' => ['mode' => 'rise_run', 'rise' => 2, 'rise-unit' => 'ft', 'run' => 100, 'run-unit' => 'ft'],
        'Elevations 100 → 97.5 ft' => ['mode' => 'elevations', 'start' => 100, 'start-unit' => 'ft', 'end' => 97.5, 'end-unit' => 'ft', 'distance' => 120, 'distance-unit' => 'ft'],
        'Yard drainage 6 in in 10 ft' => ['mode' => 'rise_run', 'rise' => -6, 'rise-unit' => 'in', 'run' => 10, 'run-unit' => 'ft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'angle' => ['label' => 'Angle'],
            'ratio' => ['label' => 'Ratio'],
            'per_ft' => ['label' => 'Per foot'],
            'slope_length' => ['label' => 'Slope length'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grade = rise ÷ run × 100</li>
            <li>angle = atan(rise ÷ run)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
