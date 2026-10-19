<x-calc.page
    title="EROA - Mitral Regurgitation Calculator - SolveKit"
    description="Free EROA calculator: effective regurgitant orifice area and regurgitant volume for mitral regurgitation by the PISA method, with the ASE severity grade."
    lede="Grade mitral regurgitation by EROA."
    about="The effective regurgitant orifice area (EROA) is the size of the leak through the mitral valve. By PISA: EROA = 2π r² × Va ÷ peak MR velocity. In primary mitral regurgitation, 0.40 cm² or more is severe, 0.20–0.39 moderate and under 0.20 mild (ASE 2017); in secondary MR lower values carry risk too. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'pisa', 'fields' => ['radius', 'alias', 'vmax', 'vti']]"
    :how-to="[
        ['name' => 'Measure the PISA radius', 'text' => 'With the aliasing velocity lowered to 30–40 cm/s.'],
        ['name' => 'Enter the CW Doppler velocity and VTI', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What EROA and volume does a 0.9 cm PISA radius give?', 'answer' => '0.41 cm², 61 mL regurgitant volume (severe 60 or more).'],
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

    <x-calc.result label="EROA" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['radius' => 0.9, 'alias' => 40, 'vmax' => 500, 'vti' => 150],
        'Moderate' => ['radius' => 0.7, 'alias' => 35, 'vmax' => 480, 'vti' => 140],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rvol' => ['label' => 'Regurgitant volume'],
            'flow' => ['label' => 'Regurgitant flow'],
            'severity' => ['label' => 'Severity'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EROA = 2πr² × Va ÷ Vmax</li>
            <li>RVol = EROA × VTI</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
