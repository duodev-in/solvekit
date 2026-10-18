<x-calc.page
    title="Round Pen Calculator - SolveKit"
    description="Free round pen calculator: number of panels for a horse round pen from its diameter, panel length and gate."
    lede="Work out how many panels a round pen needs."
    about="The circumference is π × diameter. Panels = (circumference − gate) ÷ panel length, rounded up. Straight panels make a regular polygon, so the pen's real diameter comes from the number of sides (gate included)."
    :calc="['engine' => 'con-framing', 'tool' => 'round_pen', 'fields' => ['diameter', 'panel', 'gate'], 'unitFields' => ['diameter' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'panel' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'gate' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the diameter', 'text' => 'And the panel length.'],
        ['name' => 'Add the gate', 'text' => 'If it is a separate panel.'],
    ]"
    :faqs="[
        ['question' => 'How many 12 ft panels for a 60 ft round pen?', 'answer' => '15 panels plus a 12 ft gate.'],
        ['question' => 'What size round pen for horses?', 'answer' => 'Often 50–60 ft for training, larger for riding.'],
        ['question' => 'How much area is a 60 ft pen?', 'answer' => 'About 2,827 ft².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="diameter" label="Pen diameter" value="60" min="0" placeholder="Pen diameter">
            <label for="calc-diameter-unit" class="sr-only">Pen diameter unit</label>
            <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="panel" label="Panel length" value="12" min="0" placeholder="Panel length">
            <label for="calc-panel-unit" class="sr-only">Panel length unit</label>
            <select id="calc-panel-unit" name="panel-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="gate" label="Gate width (optional)" value="12" min="0" placeholder="Gate width (optional)">
            <label for="calc-gate-unit" class="sr-only">Gate width (optional) unit</label>
            <select id="calc-gate-unit" name="gate-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Panels" />

    <x-calc.options :examples="[
        '60 ft, 12 ft panels' => ['diameter' => 60, 'diameter-unit' => 'ft', 'panel' => 12, 'panel-unit' => 'ft', 'gate' => 12, 'gate-unit' => 'ft'],
        '50 ft, 10 ft panels' => ['diameter' => 50, 'diameter-unit' => 'ft', 'panel' => 10, 'panel-unit' => 'ft', 'gate' => 10, 'gate-unit' => 'ft'],
        '18 m, 3.6 m panels' => ['diameter' => 18, 'diameter-unit' => 'm', 'panel' => 3.6, 'panel-unit' => 'm', 'gate' => 0, 'gate-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'circumference' => ['label' => 'Circumference'],
            'actual' => ['label' => 'Actual size'],
            'area' => ['label' => 'Area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C = π D</li>
            <li>panels = ⌈(C − gate) ÷ panel⌉</li>
            <li>actual D = panel ÷ sin(π ÷ sides)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
