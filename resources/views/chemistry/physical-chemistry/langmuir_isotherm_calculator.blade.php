<x-calc.page
    title="Langmuir Isotherm Calculator - SolveKit"
    description="Free Langmuir isotherm calculator: surface coverage from K and pressure, or fit q max and K to adsorption data."
    lede="Work out surface coverage with the Langmuir isotherm, or fit it to your data."
    about="The Langmuir isotherm θ = KP ÷ (1 + KP) describes monolayer adsorption on identical sites. In fit mode, q max and K are found by non-linear least squares on the original data, which is more reliable than fitting a linearized plot."
    :calc="['engine' => 'chem-physical', 'tool' => 'langmuir', 'fields' => ['mode', 'k', 'pressure', 'q_max', 'data']]"
    :how-to="[
        ['name' => 'Coverage mode', 'text' => 'Enter K and the pressure.'],
        ['name' => 'Fit mode', 'text' => 'Paste your adsorption data.'],
    ]"
    :faqs="[
        ['question' => 'What does θ mean?', 'answer' => 'The fraction of surface sites occupied.'],
        ['question' => 'When does Langmuir apply?', 'answer' => 'Monolayer adsorption on uniform sites without interactions between adsorbed molecules.'],
        ['question' => 'Why not use the linear plot?', 'answer' => 'Linearizing distorts the errors; a direct non-linear fit is more accurate.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Mode" :options="['coverage' => 'Coverage', 'fit' => 'Fit data']" selected="coverage" />

    <div data-show-when="mode:coverage">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="k" label="Langmuir constant K" value="2" min="0" />
            <x-calc.field name="pressure" label="Pressure or concentration" value="0.5" min="0" />
            <x-calc.field name="q_max" label="q max (optional)" value="" min="0" placeholder="Optional" />
        </div>
    </div>

    <div data-show-when="mode:fit" hidden>
        <x-calc.textarea name="data" label="Pressure and amount adsorbed, one pair per line" value="0.1 0.95
0.2 1.6
0.5 2.6
1 3.3
2 3.8
4 4.1" rows="6" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'K = 2, P = 0.5' => ['mode' => 'coverage', 'k' => 2, 'pressure' => 0.5, 'q_max' => ''],
        'Fit adsorption data' => ['mode' => 'fit', 'data' => '0.1 0.95
0.2 1.6
0.5 2.6
1 3.3
2 3.8
4 4.1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Fitted isotherm" name="isotherm" />
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'K'],
            'r2' => ['label' => 'R²'],
            'coverage' => ['label' => 'Coverage'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = KP ÷ (1 + KP)</li>
            <li>q = q max KP ÷ (1 + KP)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
