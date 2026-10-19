<x-calc.page
    title="ABI Calculator (Ankle-Brachial Index) - SolveKit"
    description="Free ABI calculator: ankle-brachial index for each leg from ankle and arm systolic pressures, with the PAD bands."
    lede="Calculate the ankle-brachial index."
    about="ABI = ankle systolic pressure ÷ the higher of the two arm pressures, for each leg. AHA/ACC 2016: 1.00–1.40 normal, 0.91–0.99 borderline, 0.90 or less peripheral artery disease and over 1.40 non-compressible (stiff) arteries. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'abi', 'fields' => ['arm_right', 'arm_left', 'ankle_right', 'ankle_left']]"
    :how-to="[
        ['name' => 'Measure both arms', 'text' => ''],
        ['name' => 'Measure both ankles', 'text' => 'The higher of the two ankle arteries on each side.'],
    ]"
    :faqs="[
        ['question' => 'What is the ABI with arms 130/128 and ankles 120 and 105?', 'answer' => '0.81: Peripheral artery disease (0.41–0.90).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="arm_right" label="Right arm systolic" value="130" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="arm_left" label="Left arm systolic" value="128" min="0" step="1" suffix="mmHg" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ankle_right" label="Right ankle systolic" value="120" min="0" step="1" suffix="mmHg" />
        <x-calc.field name="ankle_left" label="Left ankle systolic" value="105" min="0" step="1" suffix="mmHg" />
    </div>

    <x-calc.result label="Ankle-brachial index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['arm_right' => 130, 'arm_left' => 128, 'ankle_right' => 120, 'ankle_left' => 105],
        'Normal' => ['arm_right' => 125, 'arm_left' => 122, 'ankle_right' => 135, 'ankle_left' => 132],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'right' => ['label' => 'Right leg'],
            'left' => ['label' => 'Left leg'],
            'method' => ['label' => 'Method'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ABI = ankle ÷ higher arm</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
