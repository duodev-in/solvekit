<x-calc.page
    title="FEV1/FVC Ratio Calculator - SolveKit"
    description="Free FEV1/FVC calculator: the ratio of forced expiratory volume in 1 second to forced vital capacity, with the GOLD obstruction rule and grade."
    lede="Check your FEV₁/FVC ratio."
    about="After a bronchodilator, an FEV₁/FVC ratio under 0.70 confirms airflow obstruction by the GOLD criteria. The GOLD grade then follows FEV₁ % predicted: 80% or more mild, 50–79% moderate, 30–49% severe and under 30% very severe. Lung function labs also compare the ratio with its lower limit of normal (GLI equations). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'fev1', 'fields' => ['fev1', 'fvc', 'fev1_pct']]"
    :how-to="[
        ['name' => 'Enter FEV₁ and FVC', 'text' => 'From spirometry after a bronchodilator.'],
        ['name' => 'Enter FEV₁ % predicted', 'text' => 'For the grade.'],
    ]"
    :faqs="[
        ['question' => 'What is the ratio for FEV₁ 2.4 L and FVC 3.8 L?', 'answer' => '0.63: Below 0.70: airflow obstruction (GOLD) (GOLD 2 (moderate, 50–79%)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="fev1" label="FEV₁" value="2.4" min="0" step="any" suffix="L" />
        <x-calc.field name="fvc" label="FVC" value="3.8" min="0" step="any" suffix="L" />
        <x-calc.field name="fev1_pct" label="FEV₁ % predicted" value="65" min="0" max="200" step="any" suffix="%" />
    </div>

    <x-calc.result label="FEV₁/FVC" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fev1' => 2.4, 'fvc' => 3.8, 'fev1_pct' => 65],
        'Normal' => ['fev1' => 3.4, 'fvc' => 4.2, 'fev1_pct' => 95],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'grade' => ['label' => 'GOLD grade'],
            'percent' => ['label' => 'As a percentage'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = FEV₁ ÷ FVC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
