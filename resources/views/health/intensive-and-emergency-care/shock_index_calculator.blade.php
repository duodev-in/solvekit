<x-calc.page
    title="Shock Index Calculator - SolveKit"
    description="Free shock index calculator: heart rate divided by systolic blood pressure, with the modified shock index."
    lede="Calculate the shock index."
    about="The shock index (Allgöwer & Burri 1967) is heart rate ÷ systolic BP. Normal is 0.5–0.7; 1.0 or more suggests significant blood loss or shock even when blood pressure still looks normal. The modified shock index uses mean arterial pressure. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'shock_index', 'fields' => ['hr', 'sbp', 'dbp']]"
    :how-to="[
        ['name' => 'Enter heart rate and systolic pressure', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the shock index at 110 bpm and 100 mmHg?', 'answer' => '1.10: 1.0 or more: suggests shock.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="hr" label="Heart rate" value="110" min="0" max="300" step="1" suffix="bpm" />
        <x-calc.field name="sbp" label="Systolic" value="100" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="dbp" label="Diastolic (optional)" value="65" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Shock index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hr' => 110, 'sbp' => 100, 'dbp' => 65],
        'Normal' => ['hr' => 72, 'sbp' => 120, 'dbp' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'modified' => ['label' => 'Modified shock index'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SI = HR ÷ SBP</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
