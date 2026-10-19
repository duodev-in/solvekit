<x-calc.page
    title="Blood Pressure Calculator - SolveKit"
    description="Free blood pressure calculator: your category (normal, elevated, stage 1 or 2 hypertension, crisis) by the ACC/AHA 2017 and ESC 2024 guidelines, with mean arterial and pulse pressure."
    lede="Check your blood pressure category."
    about="ACC/AHA 2017: normal under 120/80; elevated 120–129 with diastolic under 80; stage 1 hypertension 130–139 or 80–89; stage 2 140/90 or more; over 180/120 is a hypertensive crisis. ESC 2024 calls 120–139/70–89 elevated and 140/90 hypertension. When systolic and diastolic fall in different categories the higher one counts. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'bp', 'fields' => ['sbp', 'dbp']]"
    :how-to="[
        ['name' => 'Sit quietly for 5 minutes', 'text' => 'Arm supported at heart level.'],
        ['name' => 'Enter the reading', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What category is 128/82?', 'answer' => 'Stage 1 hypertension (130–139 or 80–89).'],
        ['question' => 'And 145/95?', 'answer' => 'Stage 2 hypertension (140+ or 90+).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sbp" label="Systolic" value="128" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="dbp" label="Diastolic" value="82" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Blood pressure category" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sbp' => 128, 'dbp' => 82],
        'Stage 2' => ['sbp' => 145, 'dbp' => 95],
        'Normal' => ['sbp' => 115, 'dbp' => 75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'category' => ['label' => 'ACC/AHA category'],
            'map' => ['label' => 'Mean arterial pressure'],
            'pulse' => ['label' => 'Pulse pressure'],
            'esc' => ['label' => 'ESC 2024'],
            'check' => ['label' => 'Measuring'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>higher category of systolic and diastolic</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
