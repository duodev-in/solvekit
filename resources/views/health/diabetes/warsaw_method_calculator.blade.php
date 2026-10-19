<x-calc.page
    title="Warsaw Method Calculator - SolveKit"
    description="Free Warsaw method calculator: fat-protein units (FPU) of a meal, the carbohydrate they are counted like, and the extended bolus duration used in the Warsaw method."
    lede="Count fat-protein units."
    about="The Warsaw method (Pańkowska et al. 2009) counts 100 kcal from fat and protein as one fat-protein unit: FPU = (9 × fat g + 4 × protein g) ÷ 100, each counted like 10 g of carbohydrate and spread over 3–8 hours. This page shows units only; insulin doses must come from your diabetes team. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'warsaw', 'fields' => ['fat', 'protein']]"
    :how-to="[
        ['name' => 'Enter the meal\'s fat and protein', 'text' => 'From labels or an app.'],
    ]"
    :faqs="[
        ['question' => 'How many FPU are 25 g fat and 35 g protein?', 'answer' => '3.6 FPU.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fat" label="Fat" value="25" min="0" step="any" suffix="g" />
        <x-calc.field name="protein" label="Protein" value="35" min="0" step="any" suffix="g" />
    </div>

    <x-calc.result label="Fat-protein units" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fat' => 25, 'protein' => 35],
        'Pizza' => ['fat' => 40, 'protein' => 45],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'carbs' => ['label' => 'Carbohydrate equivalent'],
            'duration' => ['label' => 'Duration'],
            'care' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FPU = (9 F + 4 P) ÷ 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
