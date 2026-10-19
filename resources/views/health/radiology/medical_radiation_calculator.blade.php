<x-calc.page
    title="Medical Radiation Calculator - SolveKit"
    description="Free medical radiation calculator: the total effective dose from your X-rays, CT scans and other imaging, compared with natural background radiation."
    lede="Add up your radiation from medical imaging."
    about="Typical adult effective doses (Mettler et al., Radiology 2008): chest X-ray 0.1 mSv, mammogram 0.4, CT head 2, CT chest 7, CT abdomen 8 and CT coronary angiography 16 mSv. In the US, natural background radiation averages 3.1 mSv a year (NCRP Report 160). A needed test's benefit usually far outweighs its small risk. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'medical_radiation', 'fields' => ['exams']]"
    :how-to="[
        ['name' => 'Add each test and how many', 'text' => 'Pick from the list.'],
    ]"
    :faqs="[
        ['question' => 'What dose are 2 chest X-rays, a head CT and a mammogram?', 'answer' => '2.60 mSv (About 306 days of natural background radiation (3.1 mSv a year in the US)).'],
    ]"
>
    <x-calc.rows-editor name="exams" label="Imaging tests (test, how many)" :columns="['exam' => 'Test', 'count' => 'How many']" :rows="[['Chest X-ray', '2'], ['CT head', '1'], ['Mammogram', '1']]" add-label="Add test" :text="['exam', 'count']" :lists="['exam' => ['Chest X-ray', 'Dental X-ray (intraoral)', 'Dental panoramic X-ray', 'Mammogram', 'Bone density (DXA)', 'Arm or leg X-ray', 'Lumbar spine X-ray', 'Abdomen X-ray', 'Pelvis X-ray', 'CT head', 'CT chest', 'CT abdomen', 'CT pelvis', 'CT coronary angiography', 'CT colonography', 'Barium enema', 'Upper GI series', 'Bone scan', 'PET scan (FDG)']]" />

    <x-calc.result label="Total effective dose" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['exams' => 'Chest X-ray	2
CT head	1
Mammogram	1'],
        'CT heavy' => ['exams' => 'CT chest	2
CT abdomen	1
PET scan (FDG)	1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'background' => ['label' => 'Background equivalent'],
            'unknown' => ['label' => 'Tests'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="Tests" name="exams" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dose = Σ typical dose × number</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
