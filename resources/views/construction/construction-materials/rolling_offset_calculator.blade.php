<x-calc.page
    title="Rolling Offset Calculator - SolveKit"
    description="Free rolling offset calculator: pipe travel, true offset and run for a rolling offset with 45°, 22½°, 60° or any fittings."
    lede="Work out the travel of a rolling offset in pipe."
    about="A rolling offset moves a pipe both up (the offset) and over (the roll). The true offset is the diagonal √(offset² + roll²); the travel between fitting centers is the true offset ÷ sin θ and the run (setback) is the true offset ÷ tan θ, for fittings of angle θ. For 45° fittings the travel is 1.414 × the true offset."
    :calc="['engine' => 'con-trig', 'tool' => 'rolling_offset', 'fields' => ['offset', 'roll', 'angle'], 'unitFields' => ['offset' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'roll' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Measure the offset and roll', 'text' => 'Center line to center line.'],
        ['name' => 'Choose the fittings', 'text' => 'Their angle.'],
    ]"
    :faqs="[
        ['question' => 'What is the travel for a 12 × 8 in rolling offset with 45s?', 'answer' => 'True offset 14.42 in, travel 20.40 in.'],
        ['question' => 'What is the 45° constant?', 'answer' => '1.414: travel = true offset × 1.414.'],
        ['question' => 'Do I subtract fitting take-off?', 'answer' => 'Yes, to cut the pipe subtract each fitting\'s take-off from the travel.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="offset" label="Offset (rise)" value="12" min="0" placeholder="Offset (rise)">
            <label for="calc-offset-unit" class="sr-only">Offset (rise) unit</label>
            <select id="calc-offset-unit" name="offset-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="roll" label="Roll (sideways)" value="8" min="0" placeholder="Roll (sideways)">
            <label for="calc-roll-unit" class="sr-only">Roll (sideways) unit</label>
            <select id="calc-roll-unit" name="roll-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="angle" label="Fitting angle" :options="['45' => '45°', '22.5' => '22½°', '60' => '60°', '11.25' => '11¼°', '30' => '30°']" selected="45" />
    </div>

    <x-calc.result label="Travel (center to center)" />

    <x-calc.options :examples="[
        '12 × 8 in with 45s' => ['offset' => 12, 'offset-unit' => 'in', 'roll' => 8, 'roll-unit' => 'in', 'angle' => '45'],
        '22½° fittings' => ['offset' => 6, 'offset-unit' => 'in', 'roll' => 6, 'roll-unit' => 'in', 'angle' => '22.5'],
        'Metric 300 × 200 mm' => ['offset' => 300, 'offset-unit' => 'mm', 'roll' => 200, 'roll-unit' => 'mm', 'angle' => '45'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'true' => ['label' => 'True offset'],
            'run' => ['label' => 'Run (setback)'],
            'constant' => ['label' => 'Travel constant'],
            'roll_angle' => ['label' => 'Roll angle'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>true offset = √(offset² + roll²)</li>
            <li>travel = true offset ÷ sin θ</li>
            <li>run = true offset ÷ tan θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
