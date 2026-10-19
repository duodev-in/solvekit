<x-calc.page
    title="SOFA Score Calculator - SolveKit"
    description="Free SOFA score calculator: Sequential Organ Failure Assessment across respiration, coagulation, liver, circulation, brain and kidneys (0–24), with mortality by score."
    lede="Score organ failure with SOFA."
    about="SOFA (Vincent et al. 1996) scores six organ systems 0–4 each. In Sepsis-3, a rise of 2 or more from baseline with infection defines sepsis. Ferreira et al. (2001) reported ICU mortality from under 10% at low initial scores to over 90% above 11. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['resp', 'coag', 'liver', 'cardio', 'cns', 'renal'], 'data' => ['score' => config('health_data.scores.sofa')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does P/F under 300, platelets under 100 and MAP under 70 score?', 'answer' => '5 of 24: SOFA 4–5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="resp" label="Respiration: PaO₂/FiO₂ (mmHg)" :options="['o0' => '400 or more (0 points)', 'o1' => 'Under 400 (1 point)', 'o2' => 'Under 300 (2 points)', 'o3' => 'Under 200 with respiratory support (3 points)', 'o4' => 'Under 100 with respiratory support (4 points)']" selected="o0" />
        <x-calc.select name="coag" label="Coagulation: platelets (×10³/µL)" :options="['o0' => '150 or more (0 points)', 'o1' => 'Under 150 (1 point)', 'o2' => 'Under 100 (2 points)', 'o3' => 'Under 50 (3 points)', 'o4' => 'Under 20 (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="liver" label="Liver: bilirubin" :options="['o0' => 'Under 1.2 mg/dL (20 µmol/L) (0 points)', 'o1' => '1.2–1.9 mg/dL (20–32) (1 point)', 'o2' => '2.0–5.9 mg/dL (33–101) (2 points)', 'o3' => '6.0–11.9 mg/dL (102–204) (3 points)', 'o4' => '12 mg/dL (204 µmol/L) or more (4 points)']" selected="o0" />
        <x-calc.select name="cardio" label="Cardiovascular" :options="['o0' => 'MAP 70 mmHg or more (0 points)', 'o1' => 'MAP under 70 (1 point)', 'o2' => 'Dopamine 5 µg/kg/min or less, or any dobutamine (2 points)', 'o3' => 'Dopamine over 5, or adrenaline or noradrenaline 0.1 or less (3 points)', 'o4' => 'Dopamine over 15, or adrenaline or noradrenaline over 0.1 (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="cns" label="Central nervous system: GCS" :options="['o0' => '15 (0 points)', 'o1' => '13–14 (1 point)', 'o2' => '10–12 (2 points)', 'o3' => '6–9 (3 points)', 'o4' => 'Under 6 (4 points)']" selected="o0" />
        <x-calc.select name="renal" label="Renal: creatinine or urine output" :options="['o0' => 'Under 1.2 mg/dL (110 µmol/L) (0 points)', 'o1' => '1.2–1.9 mg/dL (110–170) (1 point)', 'o2' => '2.0–3.4 mg/dL (171–299) (2 points)', 'o3' => '3.5–4.9 mg/dL (300–440) or urine under 500 mL/day (3 points)', 'o4' => '5.0 mg/dL (440 µmol/L) or more, or urine under 200 mL/day (4 points)']" selected="o0" />
    </div>

    <x-calc.result label="SOFA score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['resp' => 'o0', 'coag' => 'o0', 'liver' => 'o0', 'cardio' => 'o0', 'cns' => 'o0', 'renal' => 'o0'],
        'Highest' => ['resp' => 'o4', 'coag' => 'o4', 'liver' => 'o4', 'cardio' => 'o4', 'cns' => 'o4', 'renal' => 'o4'],
        'Three organs' => ['resp' => 'o2', 'coag' => 'o2', 'liver' => 'o0', 'cardio' => 'o1', 'cns' => 'o0', 'renal' => 'o0'],
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
            <li>SOFA score: sum of item points (maximum 24)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
