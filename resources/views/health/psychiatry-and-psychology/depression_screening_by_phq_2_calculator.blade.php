<x-calc.page
    title="Depression Screening by PHQ-2 Calculator - SolveKit"
    description="Free PHQ-2 depression screen: two questions about low mood and loss of interest over the last two weeks, scored 0–6."
    lede="Take the two-question depression screen."
    about="The PHQ-2 (Kroenke et al. 2003) asks about the two core symptoms of depression. A score of 3 or more is a positive screen and should be followed by the PHQ-9 and a talk with a clinician. If you are struggling, please reach out to someone you trust or a helpline. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2'], 'data' => ['score' => config('health_data.scores.phq2')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does “more than half the days” for both questions score?', 'answer' => '4 of 6: Positive screen (3–6).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="Over the last 2 weeks: little interest or pleasure in doing things" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q2" label="Over the last 2 weeks: feeling down, depressed, or hopeless" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <x-calc.result label="PHQ-2" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o0', 'q2' => 'o0'],
        'Highest' => ['q1' => 'o3', 'q2' => 'o3'],
        'Both often' => ['q1' => 'o2', 'q2' => 'o2'],
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
            <li>PHQ-2: sum of item points (maximum 6)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
