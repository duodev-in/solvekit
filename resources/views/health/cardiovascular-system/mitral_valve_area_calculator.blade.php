<x-calc.page
    title="Mitral Valve Area Calculator - SolveKit"
    description="Free mitral valve area calculator: MVA from the pressure half-time (220 ÷ PHT) or the continuity equation, with the mitral stenosis grade."
    lede="Calculate mitral valve area."
    about="The Hatle pressure half-time method: MVA = 220 ÷ PHT (ms). The continuity method: MVA = LVOT area × VTI(LVOT) ÷ VTI(mitral). ACC/AHA 2020: an area of 1.5 cm² or less is severe mitral stenosis and 1.0 cm² or less very severe. PHT is less reliable just after valvuloplasty or with aortic regurgitation. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'mva', 'fields' => ['mode', 'pht', 'lvot', 'vti_lvot', 'vti_mv']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter the measurements', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the MVA with a pressure half-time of 150 ms?', 'answer' => '1.47 cm²: Severe mitral stenosis (1.5 cm² or less).'],
        ['question' => 'And by continuity (LVOT 2.0 cm, VTIs 20 and 50 cm)?', 'answer' => '1.26 cm².'],
    ]"
>
    <x-calc.segmented name="mode" legend="Method" :options="['pht' => 'Pressure half-time', 'continuity' => 'Continuity equation']" selected="pht" />

    <div data-show-when="mode:pht">
        <x-calc.field name="pht" label="Pressure half-time" value="150" min="0" step="1" suffix="ms" />
    </div>

    <div data-show-when="mode:continuity" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="lvot" label="LVOT diameter" value="2.0" min="0" step="any" suffix="cm" />
            <x-calc.field name="vti_lvot" label="LVOT VTI" value="20" min="0" step="any" suffix="cm" />
            <x-calc.field name="vti_mv" label="Mitral VTI" value="50" min="0" step="any" suffix="cm" />
        </div>
    </div>

    <x-calc.result label="Mitral valve area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'pht', 'pht' => 150, 'lvot' => 2, 'vti_lvot' => 20, 'vti_mv' => 50],
        'Continuity' => ['mode' => 'continuity', 'pht' => 150, 'lvot' => 2, 'vti_lvot' => 20, 'vti_mv' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'method' => ['label' => 'Method'],
            'source' => ['label' => 'Staging'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MVA = 220 ÷ PHT</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
