<x-calc.page
    title="Weight Loss Percentage Calculator - SolveKit"
    description="Free weight loss percentage calculator: the percentage of body weight lost, the weekly rate and the 5% and 10% milestones."
    lede="Work out the percentage of weight you have lost."
    about="Weight loss % = (start − current) ÷ start × 100. Losing 5% of body weight is linked with improved blood pressure, blood sugar and cholesterol, and 10% with larger benefits; 0.5–1 kg (1–2 lb) a week is the usual safe pace. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'weight_loss', 'fields' => ['start', 'current', 'weeks'], 'unitFields' => ['start' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all(), 'current' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter starting and current weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What percentage is 95 kg down to 88 kg?', 'answer' => '7.4% (7.0 kg (15.4 lb) lost over 12 weeks).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting weight" value="95" min="0" placeholder="Starting weight">
            <label for="calc-start-unit" class="sr-only">Starting weight unit</label>
            <select id="calc-start-unit" name="start-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="current" label="Current weight" value="88" min="0" placeholder="Current weight">
            <label for="calc-current-unit" class="sr-only">Current weight unit</label>
            <select id="calc-current-unit" name="current-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.field name="weeks" label="Weeks (optional)" value="12" min="0" step="1" />

    <x-calc.result label="Weight lost" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['start' => 95, 'start-unit' => 'kg', 'current' => 88, 'current-unit' => 'kg', 'weeks' => 12],
        'Pounds' => ['start' => 220, 'start-unit' => 'lb', 'current' => 196, 'current-unit' => 'lb', 'weeks' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'perWeek' => ['label' => 'Weekly rate'],
            'milestone' => ['label' => '5% milestone'],
            'ten' => ['label' => '10% milestone'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>% = (start − now) ÷ start × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
