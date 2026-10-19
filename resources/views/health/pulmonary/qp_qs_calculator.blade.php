<x-calc.page
    title="Qp/Qs Calculator - SolveKit"
    description="Free Qp/Qs calculator: pulmonary to systemic flow ratio from oxygen saturations, for intracardiac shunts."
    lede="Calculate the shunt ratio Qp/Qs."
    about="By the Fick principle, Qp/Qs = (SaO₂ − SvO₂) ÷ (SpvO₂ − SpaO₂): systemic arterial minus mixed venous, over pulmonary venous minus pulmonary arterial saturation. 1.0 is no net shunt; 1.5 or more is a significant left-to-right shunt that often prompts closure. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'qpqs', 'fields' => ['sao2', 'svo2', 'spvo2', 'spao2']]"
    :how-to="[
        ['name' => 'Enter the four saturations', 'text' => 'From the catheter study.'],
    ]"
    :faqs="[
        ['question' => 'What is Qp/Qs with saturations 96, 70, 98 and 84%?', 'answer' => '1.86: 1.5–2: significant left-to-right shunt.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sao2" label="Systemic arterial (SaO₂)" value="96" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="svo2" label="Mixed venous (SvO₂)" value="70" min="0" max="100" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="spvo2" label="Pulmonary venous (SpvO₂)" value="98" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="spao2" label="Pulmonary arterial (SpaO₂)" value="84" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Qp/Qs" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sao2' => 96, 'svo2' => 70, 'spvo2' => 98, 'spao2' => 84],
        'No shunt' => ['sao2' => 97, 'svo2' => 72, 'spvo2' => 98, 'spao2' => 73],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Qp/Qs = (SaO₂ − SvO₂) ÷ (SpvO₂ − SpaO₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
