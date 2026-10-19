<x-calc.page
    title="Sepsis Calculator (Sepsis-3 Criteria) - SolveKit"
    description="Free Sepsis-3 calculator: whether the 2016 criteria for sepsis (infection with a SOFA rise of 2 or more) and septic shock (vasopressors and lactate over 2 mmol/L) are met."
    lede="Check the Sepsis-3 criteria."
    about="Sepsis-3 (Singer et al., JAMA 2016) defines sepsis as life-threatening organ dysfunction from infection: suspected infection with an acute rise in SOFA score of 2 or more. Septic shock adds the need for vasopressors to keep MAP 65 mmHg or more and lactate over 2 mmol/L despite adequate fluids. Sepsis is an emergency. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'sepsis', 'fields' => ['infection', 'sofa_rise', 'lactate', 'vasopressors']]"
    :how-to="[
        ['name' => 'Tick suspected infection', 'text' => ''],
        ['name' => 'Enter the SOFA change', 'text' => 'Use the SOFA Score calculator.'],
        ['name' => 'Enter lactate and vasopressor use', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Does infection with a SOFA rise of 3 meet Sepsis-3?', 'answer' => 'Sepsis.'],
        ['question' => 'And with vasopressors and lactate 4?', 'answer' => 'Septic shock.'],
    ]"
>
    <x-calc.checkbox name="infection" label="Suspected or confirmed infection" :checked="true" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sofa_rise" label="Rise in SOFA score from baseline" value="3" min="0" max="24" step="1" />
        <x-calc.field name="lactate" label="Lactate" value="1.8" min="0" step="any" suffix="mmol/L" />
    </div>

    <x-calc.checkbox name="vasopressors" label="Needs vasopressors to keep MAP 65 or more after fluids" :checked="false" />

    <x-calc.result label="Sepsis-3" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['infection' => true, 'sofa_rise' => 3, 'lactate' => 1.8, 'vasopressors' => false],
        'Shock' => ['infection' => true, 'sofa_rise' => 6, 'lactate' => 4, 'vasopressors' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sepsis' => ['label' => 'Sepsis'],
            'shock' => ['label' => 'Septic shock'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sepsis: infection + ΔSOFA ≥ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
