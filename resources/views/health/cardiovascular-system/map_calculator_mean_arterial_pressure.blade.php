<x-calc.page
    title="MAP Calculator (Mean Arterial Pressure) - SolveKit"
    description="Free MAP calculator: mean arterial pressure from systolic and diastolic blood pressure, with pulse pressure."
    lede="Calculate mean arterial pressure."
    about="Mean arterial pressure is the average pressure over one heartbeat: MAP ≈ DBP + (SBP − DBP) ÷ 3, because the heart spends about two-thirds of each beat in diastole. Normal MAP is about 70–100 mmHg; sepsis guidelines aim for 65 mmHg or more. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'map', 'fields' => ['sbp', 'dbp']]"
    :how-to="[
        ['name' => 'Enter systolic and diastolic', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the MAP of 120/80?', 'answer' => '93 mmHg.'],
        ['question' => 'And 90/50?', 'answer' => '63 mmHg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sbp" label="Systolic" value="120" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="dbp" label="Diastolic" value="80" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Mean arterial pressure" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sbp' => 120, 'dbp' => 80],
        'Low' => ['sbp' => 90, 'dbp' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pulse' => ['label' => 'Pulse pressure'],
            'formula' => ['label' => 'Formula'],
            'target' => ['label' => 'Target'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MAP = DBP + (SBP − DBP) ÷ 3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
