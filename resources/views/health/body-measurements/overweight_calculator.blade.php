<x-calc.page
    title="Overweight Calculator - SolveKit"
    description="Free overweight calculator: how many kilograms or pounds you are above or below the healthy BMI range for your height."
    lede="See how far you are from the healthy range."
    about="The healthy weight range is BMI 18.5–24.9 (WHO). Overweight starts at BMI 25 and obesity at 30. The result shows the weight change to reach the range; even a 5–10% loss brings health benefits when weight is high. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'overweight', 'fields' => ['height', 'weight'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all(), 'weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and weight', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How overweight is 175 cm and 90 kg?', 'answer' => '13.7 kg (30.3 lb) over.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="height" label="Height" value="170" min="0" placeholder="Height">
            <label for="calc-height-unit" class="sr-only">Height unit</label>
            <select id="calc-height-unit" name="height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Compared with the healthy BMI range" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 90, 'weight-unit' => 'kg'],
        'Healthy' => ['height' => 175, 'height-unit' => 'cm', 'weight' => 70, 'weight-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'range' => ['label' => 'Healthy range'],
            'bmi' => ['label' => 'BMI'],
            'obesity' => ['label' => 'Obesity threshold'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>excess = weight − 24.9 × height²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
