<x-calc.page
    title="GAD-7 Calculator - SolveKit"
    description="Free GAD-7 calculator: the seven-question Generalized Anxiety Disorder scale, scored 0–21 with the mild, moderate and severe cut-offs."
    lede="Take the GAD-7 anxiety questionnaire."
    about="The GAD-7 (Spitzer et al. 2006) rates seven anxiety symptoms over the last two weeks. Scores of 5, 10 and 15 mark mild, moderate and severe anxiety; 10 or more is the usual point for further evaluation. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7'], 'data' => ['score' => config('health_data.scores.gad7')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does “more than half the days” on every question score?', 'answer' => '14 of 21: Moderate anxiety (10–14).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="Over the last 2 weeks: feeling nervous, anxious, or on edge" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q2" label="Over the last 2 weeks: not being able to stop or control worrying" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q3" label="Over the last 2 weeks: worrying too much about different things" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q4" label="Over the last 2 weeks: trouble relaxing" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q5" label="Over the last 2 weeks: being so restless that it is hard to sit still" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q6" label="Over the last 2 weeks: becoming easily annoyed or irritable" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <x-calc.select name="q7" label="Over the last 2 weeks: feeling afraid, as if something awful might happen" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />

    <x-calc.result label="GAD-7" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o0', 'q2' => 'o0', 'q3' => 'o0', 'q4' => 'o0', 'q5' => 'o0', 'q6' => 'o0', 'q7' => 'o0'],
        'Highest' => ['q1' => 'o3', 'q2' => 'o3', 'q3' => 'o3', 'q4' => 'o3', 'q5' => 'o3', 'q6' => 'o3', 'q7' => 'o3'],
        'Often' => ['q1' => 'o2', 'q2' => 'o2', 'q3' => 'o2', 'q4' => 'o2', 'q5' => 'o2', 'q6' => 'o2', 'q7' => 'o2'],
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
            <li>GAD-7: sum of item points (maximum 21)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
