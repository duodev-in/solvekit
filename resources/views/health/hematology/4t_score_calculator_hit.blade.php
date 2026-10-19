<x-calc.page
    title="4T Score Calculator | HIT - SolveKit"
    description="Free 4Ts score calculator: pre-test probability of heparin-induced thrombocytopenia from Thrombocytopenia, Timing, Thrombosis and oTher causes."
    lede="Score the probability of HIT."
    about="The 4Ts score (Lo et al. 2006) is the recommended first step when heparin-induced thrombocytopenia is suspected (ASH 2018). A low score (0–3) makes HIT very unlikely, so lab testing is usually not needed; intermediate and high scores need HIT antibody testing and specialist advice. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['thrombocytopenia', 'timing', 'thrombosis', 'other'], 'data' => ['score' => config('health_data.scores.four_t')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a 60% fall on day 7 with no other cause score?', 'answer' => '6 of 8: High probability (6–8).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="thrombocytopenia" label="Thrombocytopenia" :options="['o0' => 'Fall under 30%, or nadir under 10 × 10⁹/L (0 points)', 'o1' => 'Fall of 30–50%, or nadir 10–19 (1 point)', 'o2' => 'Fall over 50% and nadir 20 or more (2 points)']" selected="o0" />
        <x-calc.select name="timing" label="Timing of the platelet fall" :options="['o0' => 'Under 4 days with no recent heparin (0 points)', 'o1' => 'Probably day 5–10 but unclear, after day 10, or within a day with heparin 30–100 days ago (1 point)', 'o2' => 'Clear onset on day 5–10, or within a day with heparin in the last 30 days (2 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="thrombosis" label="Thrombosis or other sequelae" :options="['o0' => 'None (0 points)', 'o1' => 'Progressive or recurrent thrombosis, non-necrotising skin lesions, or suspected thrombosis (1 point)', 'o2' => 'New proven thrombosis, skin necrosis, or acute reaction after an IV heparin bolus (2 points)']" selected="o0" />
        <x-calc.select name="other" label="Other causes of thrombocytopenia" :options="['o0' => 'Definite (0 points)', 'o1' => 'Possible (1 point)', 'o2' => 'None apparent (2 points)']" selected="o0" />
    </div>

    <x-calc.result label="4Ts score" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['thrombocytopenia' => 'o0', 'timing' => 'o0', 'thrombosis' => 'o0', 'other' => 'o0'],
        'Highest' => ['thrombocytopenia' => 'o2', 'timing' => 'o2', 'thrombosis' => 'o2', 'other' => 'o2'],
        'Classic HIT' => ['thrombocytopenia' => 'o2', 'timing' => 'o2', 'thrombosis' => 'o0', 'other' => 'o2'],
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
            <li>4Ts score: sum of item points (maximum 8)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
