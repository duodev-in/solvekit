<x-calc.page
    title="Child Pugh Calculator - SolveKit"
    description="Free Child–Pugh calculator: cirrhosis severity class A, B or C from bilirubin, albumin, INR, ascites and encephalopathy."
    lede="Score cirrhosis severity (Child–Pugh)."
    about="The Child–Pugh score (Pugh et al. 1973) adds 1–3 points for each of five measures: 5–6 points is class A, 7–9 class B and 10–15 class C. It guides prognosis and drug dosing decisions by clinicians; MELD is used for transplant listing. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['bilirubin', 'albumin', 'inr', 'ascites', 'encephalopathy'], 'data' => ['score' => config('health_data.scores.child_pugh')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What class is bilirubin 2.5, albumin 3.0, INR 1.8, mild ascites and no encephalopathy?', 'answer' => '9 of 15: Class B (7–9 points).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bilirubin" label="Total bilirubin" :options="['o0' => 'Under 2 mg/dL (34 µmol/L) (1 point)', 'o1' => '2–3 mg/dL (34–50 µmol/L) (2 points)', 'o2' => 'Over 3 mg/dL (50 µmol/L) (3 points)']" selected="o0" />
        <x-calc.select name="albumin" label="Albumin" :options="['o0' => 'Over 3.5 g/dL (35 g/L) (1 point)', 'o1' => '2.8–3.5 g/dL (2 points)', 'o2' => 'Under 2.8 g/dL (28 g/L) (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="inr" label="INR" :options="['o0' => 'Under 1.7 (1 point)', 'o1' => '1.7–2.3 (2 points)', 'o2' => 'Over 2.3 (3 points)']" selected="o0" />
        <x-calc.select name="ascites" label="Ascites" :options="['o0' => 'None (1 point)', 'o1' => 'Mild (or controlled with diuretics) (2 points)', 'o2' => 'Moderate to severe (3 points)']" selected="o0" />
    </div>

    <x-calc.select name="encephalopathy" label="Hepatic encephalopathy" :options="['o0' => 'None (1 point)', 'o1' => 'Grade 1–2 (or controlled with medicine) (2 points)', 'o2' => 'Grade 3–4 (3 points)']" selected="o0" />

    <x-calc.result label="Child–Pugh score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bilirubin' => 'o0', 'albumin' => 'o0', 'inr' => 'o0', 'ascites' => 'o0', 'encephalopathy' => 'o0'],
        'Highest' => ['bilirubin' => 'o2', 'albumin' => 'o2', 'inr' => 'o2', 'ascites' => 'o2', 'encephalopathy' => 'o2'],
        'Moderate' => ['bilirubin' => 'o1', 'albumin' => 'o1', 'inr' => 'o1', 'ascites' => 'o1', 'encephalopathy' => 'o0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Child–Pugh score: sum of item points (maximum 15)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
