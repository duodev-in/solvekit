<x-calc.page
    title="Ideal Weight Calculator - SolveKit"
    description="Free ideal weight calculator: ideal body weight by the Devine, Robinson, Miller and Hamwi formulas and the healthy BMI range for your height."
    lede="Find your ideal weight range."
    about="The four classic formulas start from 5 ft (152.4 cm) and add a fixed amount per inch: Devine 50/45.5 kg + 2.3 kg, Robinson 52/49 kg + 1.9/1.7 kg, Miller 56.2/53.1 kg + 1.41/1.36 kg, Hamwi 48/45.5 kg + 2.7/2.2 kg (men/women). They were made for drug dosing and insurance tables, so the healthy BMI range (18.5–24.9) is shown too. A frame adjustment of ±10% is a common convention. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'ideal_weight', 'fields' => ['height', 'sex', 'frame'], 'unitFields' => ['height' => collect(config('units.length'))->only(['cm', 'in', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter height and sex', 'text' => ''],
        ['name' => 'Pick a frame size if known', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the ideal weight for a 175 cm man?', 'answer' => '68.7 kg (151.6 lb) – 72.0 kg (158.8 lb).'],
        ['question' => 'And a 163 cm woman?', 'answer' => '54.7 kg (120.6 lb) – 58.8 kg (129.6 lb).'],
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
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.select name="frame" label="Frame (optional)" :options="['medium' => 'Medium or unsure', 'small' => 'Small', 'large' => 'Large']" selected="medium" />

    <x-calc.result label="Ideal weight (four formulas)" />

    <x-calc.options :decimals="false" :examples="[
        'Man 175' => ['height' => 175, 'height-unit' => 'cm', 'sex' => 'male', 'frame' => 'medium'],
        'Woman 163' => ['height' => 163, 'height-unit' => 'cm', 'sex' => 'female', 'frame' => 'medium'],
        '6 ft large frame' => ['height' => 6, 'height-unit' => 'ft', 'sex' => 'male', 'frame' => 'large'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="Formulas" name="formulas" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Devine: 50 + 2.3 × (in − 60) for men</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
