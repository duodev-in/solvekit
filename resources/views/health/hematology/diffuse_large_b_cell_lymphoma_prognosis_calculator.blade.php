<x-calc.page
    title="Diffuse Large B-cell Lymphoma Prognosis Calculator - SolveKit"
    description="Free DLBCL prognosis calculator: the International Prognostic Index (IPI), revised IPI and NCCN-IPI from age, stage, LDH, performance status and extranodal disease."
    lede="Calculate the IPI for DLBCL."
    about="The IPI (Shipp et al. 1993) counts five factors: age over 60, stage III–IV, raised LDH, ECOG performance status 2 or more and more than one extranodal site. The R-IPI (Sehn 2007) regroups them for patients treated with rituximab, and the NCCN-IPI (Zhou 2014) refines age and LDH. Survival figures are group results from those studies, not personal predictions; discuss prognosis with the haematology team. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'ipi', 'fields' => ['age', 'stage', 'ldh_ratio', 'ecog', 'extranodal', 'major']]"
    :how-to="[
        ['name' => 'Enter age, stage and LDH ratio', 'text' => ''],
        ['name' => 'Enter performance status and extranodal disease', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the IPI for a 65-year-old with stage III disease, LDH 1.5 × normal and ECOG 1?', 'answer' => 'IPI 3 (R-IPI poor; NCCN-IPI 4 (high-intermediate)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="65" min="0" step="1" suffix="years" />
        <x-calc.select name="stage" label="Ann Arbor stage" :options="['1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV']" selected="3" />
        <x-calc.field name="ldh_ratio" label="LDH ÷ upper limit of normal" value="1.5" min="0" step="0.1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="ecog" label="ECOG performance status" :options="['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4']" selected="1" />
        <x-calc.field name="extranodal" label="Extranodal sites" value="1" min="0" step="1" />
        <x-calc.checkbox name="major" label="Bone marrow, CNS, liver/GI or lung involved" :checked="false" />
    </div>

    <x-calc.result label="International Prognostic Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 65, 'stage' => '3', 'ldh_ratio' => 1.5, 'ecog' => '1', 'extranodal' => 1, 'major' => false],
        'Low' => ['age' => 45, 'stage' => '2', 'ldh_ratio' => 0.8, 'ecog' => '0', 'extranodal' => 0, 'major' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ipi' => ['label' => 'IPI'],
            'ripi' => ['label' => 'R-IPI'],
            'nccn' => ['label' => 'NCCN-IPI'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>IPI = count of 5 factors</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
