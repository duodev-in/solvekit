<x-calc.page
    title="PISA Calculator - SolveKit"
    description="Free PISA calculator: regurgitant flow, effective regurgitant orifice area and regurgitant volume by the proximal isovelocity surface area method, with the mitral regurgitation grade."
    lede="Quantify regurgitation with PISA."
    about="PISA: flow = 2π r² × aliasing velocity; EROA = flow ÷ peak regurgitant velocity; regurgitant volume = EROA × regurgitant VTI. ASE 2017 for primary mitral regurgitation: EROA 0.40 cm² or more, or volume 60 mL or more, is severe; under 0.20 cm² mild. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'pisa', 'fields' => ['radius', 'alias', 'vmax', 'vti']]"
    :how-to="[
        ['name' => 'Enter the PISA radius and aliasing velocity', 'text' => ''],
        ['name' => 'Enter the peak MR velocity and VTI', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the EROA with a 0.9 cm radius, 40 cm/s aliasing and 500 cm/s peak velocity?', 'answer' => '0.41 cm²: Severe primary MR (0.40 cm² or more).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="radius" label="PISA radius" value="0.9" min="0" step="any" suffix="cm" />
        <x-calc.field name="alias" label="Aliasing velocity" value="40" min="0" step="any" suffix="cm/s" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="vmax" label="Peak MR velocity" value="500" min="0" step="any" suffix="cm/s" />
        <x-calc.field name="vti" label="MR VTI (optional)" value="150" min="0" step="any" suffix="cm" />
    </div>

    <x-calc.result label="Effective regurgitant orifice area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['radius' => 0.9, 'alias' => 40, 'vmax' => 500, 'vti' => 150],
        'Mild' => ['radius' => 0.5, 'alias' => 40, 'vmax' => 500, 'vti' => 140],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'flow' => ['label' => 'Regurgitant flow'],
            'rvol' => ['label' => 'Regurgitant volume'],
            'severity' => ['label' => 'Severity'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EROA = 2πr² × Va ÷ Vmax</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
