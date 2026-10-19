<x-calc.page
    title="NEWS2 Score Calculator - SolveKit"
    description="Free NEWS2 calculator: National Early Warning Score 2 from respiratory rate, oxygen saturation, oxygen use, blood pressure, pulse, consciousness and temperature, with the clinical response."
    lede="Score the National Early Warning Score 2."
    about="NEWS2 (Royal College of Physicians 2017) is used across the NHS to spot deterioration. Seven observations score 0–3; totals of 5–6 need an urgent response and 7 or more an emergency response, and any single parameter scoring 3 needs urgent review. This page uses SpO₂ scale 1; people with hypercapnic respiratory failure use scale 2 as prescribed by a clinician. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['rr', 'spo2', 'air', 'sbp', 'pulse', 'acvpu', 'temp'], 'data' => ['score' => config('health_data.scores.news2')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does respiratory rate 22, pulse 105 and temperature 38.5 °C score?', 'answer' => '4 of 20: Low clinical risk (0–4).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="rr" label="Respiratory rate (breaths a minute)" :options="['o0' => '8 or less (3 points)', 'o1' => '9–11 (1 point)', 'o2' => '12–20 (0 points)', 'o3' => '21–24 (2 points)', 'o4' => '25 or more (3 points)']" selected="o2" />
        <x-calc.select name="spo2" label="SpO₂ (scale 1)" :options="['o0' => '91% or less (3 points)', 'o1' => '92–93% (2 points)', 'o2' => '94–95% (1 point)', 'o3' => '96% or more (0 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="air" label="Air or oxygen" :options="['o0' => 'Air (0 points)', 'o1' => 'Oxygen (2 points)']" selected="o0" />
        <x-calc.select name="sbp" label="Systolic BP (mmHg)" :options="['o0' => '90 or less (3 points)', 'o1' => '91–100 (2 points)', 'o2' => '101–110 (1 point)', 'o3' => '111–219 (0 points)', 'o4' => '220 or more (3 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="pulse" label="Pulse (bpm)" :options="['o0' => '40 or less (3 points)', 'o1' => '41–50 (1 point)', 'o2' => '51–90 (0 points)', 'o3' => '91–110 (1 point)', 'o4' => '111–130 (2 points)', 'o5' => '131 or more (3 points)']" selected="o2" />
        <x-calc.select name="acvpu" label="Consciousness" :options="['o0' => 'Alert (0 points)', 'o1' => 'New confusion, or responds to voice, pain or unresponsive (3 points)']" selected="o0" />
    </div>

    <x-calc.select name="temp" label="Temperature (°C)" :options="['o0' => '35.0 or less (3 points)', 'o1' => '35.1–36.0 (1 point)', 'o2' => '36.1–38.0 (0 points)', 'o3' => '38.1–39.0 (1 point)', 'o4' => '39.1 or more (2 points)']" selected="o2" />

    <x-calc.result label="NEWS2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rr' => 'o2', 'spo2' => 'o3', 'air' => 'o0', 'sbp' => 'o3', 'pulse' => 'o2', 'acvpu' => 'o0', 'temp' => 'o2'],
        'Highest' => ['rr' => 'o0', 'spo2' => 'o0', 'air' => 'o1', 'sbp' => 'o0', 'pulse' => 'o0', 'acvpu' => 'o1', 'temp' => 'o0'],
        'Febrile' => ['rr' => 'o3', 'spo2' => 'o3', 'air' => 'o0', 'sbp' => 'o3', 'pulse' => 'o3', 'acvpu' => 'o0', 'temp' => 'o3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'alert' => ['label' => 'Single parameter of 3'],
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NEWS2: sum of item points (maximum 20)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
