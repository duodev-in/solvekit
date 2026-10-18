<x-calc.page
    title="Ramp Calculator - SolveKit"
    description="Free ramp calculator: ramp length for a rise at a 1:12 or other slope, with landings and handrail checks from ADA 405."
    lede="Work out how long a ramp must be for a rise."
    about="Ramp run = rise × slope ratio, so a 1 : 12 ramp needs 12 in of run for every inch of rise. ADA 405 sets the maximum running slope at 1 : 12, the most rise for one run at 30 in, landings at least 60 in long, and handrails on both sides when the rise is over 6 in."
    :calc="['engine' => 'con-framing', 'tool' => 'ramp', 'fields' => ['rise', 'slope', 'landing'], 'unitFields' => ['rise' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'landing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the rise', 'text' => 'Ground to door threshold.'],
        ['name' => 'Set the slope', 'text' => '1 : 12 is the steepest ADA allows.'],
    ]"
    :faqs="[
        ['question' => 'How long is a ramp for 24 in?', 'answer' => '24 ft at 1 : 12, in one run.'],
        ['question' => 'When do I need a landing?', 'answer' => 'At least every 30 in of rise, and at the top and bottom.'],
        ['question' => 'Is 1 : 12 required at home?', 'answer' => 'ADA covers public places; for homes it is a strong guide and some codes adopt it.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rise" label="Total rise" value="24" min="0" placeholder="Total rise">
            <label for="calc-rise-unit" class="sr-only">Total rise unit</label>
            <select id="calc-rise-unit" name="rise-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="slope" label="Slope 1 :" value="12" min="1" step="0.5" help="Run per unit of rise" />
    </div>

    <x-calc.field name="landing" label="Landing length" value="60" min="0" placeholder="Landing length">
        <label for="calc-landing-unit" class="sr-only">Landing length unit</label>
        <select id="calc-landing-unit" name="landing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <x-calc.result label="Ramp run" />

    <x-calc.options :examples="[
        '24 in rise, 1 : 12' => ['rise' => 24, 'rise-unit' => 'in', 'slope' => 12, 'landing' => 60, 'landing-unit' => 'in'],
        '36 in rise, 1 : 16' => ['rise' => 36, 'rise-unit' => 'in', 'slope' => 16, 'landing' => 60, 'landing-unit' => 'in'],
        '450 mm, 1 : 12' => ['rise' => 450, 'rise-unit' => 'mm', 'slope' => 12, 'landing' => 1500, 'landing-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'run' => ['label' => 'Ramp length'],
            'landings' => ['label' => 'Landings'],
            'total' => ['label' => 'Overall'],
            'handrails' => ['label' => 'Handrails'],
            'code' => ['label' => 'ADA slope'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>run = rise × slope</li>
            <li>runs = ⌈rise ÷ 30 in⌉</li>
            <li>landings = runs − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
