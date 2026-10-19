<x-calc.page
    title="BMI Weight Loss Calculator - SolveKit"
    description="Free BMI weight loss calculator: the weight for a goal BMI and how many weeks it takes at a daily calorie deficit."
    lede="Plan weight loss to a goal BMI."
    about="Goal weight = goal BMI × height². The time uses the common rule of about 7,700 kcal per kg (3,500 per lb) of body fat; in practice loss slows as the body adapts, so treat the date as an optimistic estimate. A deficit of 500 kcal a day loses about 0.5 kg a week. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'bmi_loss', 'fields' => ['height', 'weight', 'target_bmi', 'deficit'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => ''],
        ['name' => 'Choose a goal BMI and deficit', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long from 95 kg to BMI 24.9 at 175 cm with a 500 kcal deficit?', 'answer' => '41.2 weeks (18.7 kg (41.3 lb)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="175" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="95" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="target_bmi" label="Goal BMI" value="24.9" min="15" max="40" step="0.1" />
        <x-calc.field name="deficit" label="Daily calorie deficit" value="500" min="0" step="50" suffix="kcal" />
    </div>

    <x-calc.result label="Time to goal BMI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 95, 'weight-unit' => 'kg', 'target_bmi' => 24.9, 'deficit' => 500],
        'Faster' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 95, 'weight-unit' => 'kg', 'target_bmi' => 27, 'deficit' => 750],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lose' => ['label' => 'To lose'],
            'rate' => ['label' => 'Weekly rate'],
            'b25' => ['label' => 'BMI 25'],
            'safe' => ['label' => 'Pace'],
            'model' => ['label' => 'Model'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>goal kg = BMI × m²</li>
            <li>weeks = kg × 7,700 ÷ deficit ÷ 7</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
