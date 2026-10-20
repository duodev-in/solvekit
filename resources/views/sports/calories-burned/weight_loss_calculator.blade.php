<x-calc.page
    title="Weight Loss Calculator - SolveKit"
    description="Free weight loss calculator: how long to reach a goal weight on a calorie intake, with a week-by-week chart."
    lede="Find how long weight loss takes."
    about="Energy balance drives weight change: burn more than you eat and you lose. As weight falls you burn less, so loss slows; this model recalculates each week."
    :calc="['engine' => 'sp-fit', 'tool' => 'weight_loss', 'fields' => ['sex', 'age', 'h', 'w', 'goal', 'act', 'intake'], 'unitFields' => ['h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'goal' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How long to go from 90 to 80 kg on 2,000 kcal a day?', 'answer' => 'About 26 weeks.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sex" label="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <x-calc.field name="age" label="Age" value="35" min="15" step="any" />
        <x-calc.field name="h" label="Height" value="175" placeholder="Height">
            <label for="calc-h-unit" class="sr-only">Height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w" label="Current weight" value="90" min="0" placeholder="Current weight">
            <label for="calc-w-unit" class="sr-only">Current weight unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="goal" label="Goal weight" value="80" min="0" placeholder="Goal weight">
            <label for="calc-goal-unit" class="sr-only">Goal weight unit</label>
            <select id="calc-goal-unit" name="goal-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="act" label="Activity" :options="['1.2' => 'Sedentary', '1.375' => 'Light exercise 1–3 days a week', '1.55' => 'Moderate exercise 3–5 days', '1.725' => 'Hard exercise 6–7 days', '1.9' => 'Very hard exercise or physical job']" selected="1.375" />
        <x-calc.field name="intake" label="Daily calories you plan to eat" value="2000" min="800" step="any" />
    </div>

    <x-calc.result label="Time to reach the goal" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sex' => 'male', 'age' => 35, 'h' => 175, 'h-unit' => 'cm', 'w' => 90, 'w-unit' => 'kg', 'goal' => 80, 'goal-unit' => 'kg', 'act' => '1.375', 'intake' => 2000],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Projected weight" name="weight" />
        <x-calc.rows heading="Details" :rows="[
            'tdee' => ['label' => 'Calories you burn now (TDEE)'],
            'deficit' => ['label' => 'Starting daily deficit'],
            'rate' => ['label' => 'First-week loss'],
            'end' => ['label' => 'Calories burned at the goal weight'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
