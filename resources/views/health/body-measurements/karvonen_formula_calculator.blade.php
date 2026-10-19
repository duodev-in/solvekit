<x-calc.page
    title="Karvonen Formula Calculator - SolveKit"
    description="Free Karvonen formula calculator: target heart rate from your heart rate reserve, with all five training zones."
    lede="Find your target heart rate zones."
    about="Karvonen: target = (max HR − resting HR) × intensity + resting HR. Max heart rate is estimated as 220 − age or, more accurately for older adults, 208 − 0.7 × age (Tanaka 2001). ACSM calls 40–59% of heart rate reserve moderate and 60–89% vigorous. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'karvonen', 'fields' => ['age', 'rest', 'intensity', 'max_formula']]"
    :how-to="[
        ['name' => 'Measure resting heart rate', 'text' => 'First thing in the morning.'],
        ['name' => 'Choose intensity', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is a 70% target for a 35-year-old with a resting rate of 65?', 'answer' => '148 bpm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.field name="rest" label="Resting heart rate" value="65" min="30" max="120" step="1" suffix="bpm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="intensity" label="Intensity" value="70" min="30" max="100" step="1" suffix="%" />
        <x-calc.select name="max_formula" label="Max heart rate" :options="['tanaka' => '208 − 0.7 × age (Tanaka)', 'classic' => '220 − age']" selected="tanaka" />
    </div>

    <x-calc.result label="Target heart rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 35, 'rest' => 65, 'intensity' => 70, 'max_formula' => 'tanaka'],
        'Classic formula' => ['age' => 50, 'rest' => 70, 'intensity' => 60, 'max_formula' => 'classic'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'max' => ['label' => 'Max heart rate'],
            'reserve' => ['label' => 'Heart rate reserve'],
            'moderate' => ['label' => 'Moderate'],
            'vigorous' => ['label' => 'Vigorous'],
        ]" />
        <x-calc.grid heading="Zones" name="zones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>THR = (HRmax − HRrest) × % + HRrest</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
