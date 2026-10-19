<x-calc.page
    title="PHQ-9 Depression Calculator - SolveKit"
    description="Free PHQ-9 calculator: the nine-question Patient Health Questionnaire for depression, scored 0–27 with severity bands and support if you have thoughts of self-harm."
    lede="Take the PHQ-9 depression questionnaire."
    about="The PHQ-9 (Kroenke, Spitzer & Williams 2001) scores the nine DSM criteria for depression over the last two weeks: 5, 10, 15 and 20 mark mild, moderate, moderately severe and severe. Any answer other than “not at all” to question 9 deserves prompt support. It is a screening and monitoring tool, not a diagnosis. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9'], 'data' => ['score' => config('health_data.scores.phq9')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does “several days” on every question score?', 'answer' => '9 of 27: Mild (5–9). If you have thoughts of harming yourself, please talk to someone now: in the US call or text 988, in the UK and Ireland call Samaritans on 116 123, in India call Tele-MANAS on 14416, or contact local emergency services..'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="Over the last 2 weeks: little interest or pleasure in doing things" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q2" label="Over the last 2 weeks: feeling down, depressed, or hopeless" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q3" label="Over the last 2 weeks: trouble falling or staying asleep, or sleeping too much" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q4" label="Over the last 2 weeks: feeling tired or having little energy" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q5" label="Over the last 2 weeks: poor appetite or overeating" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q6" label="Over the last 2 weeks: feeling bad about yourself, or that you are a failure or have let yourself or your family down" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q7" label="Over the last 2 weeks: trouble concentrating on things, such as reading or watching television" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
        <x-calc.select name="q8" label="Over the last 2 weeks: moving or speaking so slowly that other people could have noticed, or being so fidgety or restless that you have been moving around a lot more than usual" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />
    </div>

    <x-calc.select name="q9" label="Over the last 2 weeks: thoughts that you would be better off dead, or of hurting yourself in some way" :options="['o0' => 'Not at all (0 points)', 'o1' => 'Several days (1 point)', 'o2' => 'More than half the days (2 points)', 'o3' => 'Nearly every day (3 points)']" selected="o0" />

    <x-calc.result label="PHQ-9" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o0', 'q2' => 'o0', 'q3' => 'o0', 'q4' => 'o0', 'q5' => 'o0', 'q6' => 'o0', 'q7' => 'o0', 'q8' => 'o0', 'q9' => 'o0'],
        'Highest' => ['q1' => 'o3', 'q2' => 'o3', 'q3' => 'o3', 'q4' => 'o3', 'q5' => 'o3', 'q6' => 'o3', 'q7' => 'o3', 'q8' => 'o3', 'q9' => 'o3'],
        'Several days' => ['q1' => 'o1', 'q2' => 'o1', 'q3' => 'o1', 'q4' => 'o1', 'q5' => 'o1', 'q6' => 'o1', 'q7' => 'o1', 'q8' => 'o1', 'q9' => 'o1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'alert' => ['label' => 'Safety question'],
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PHQ-9: sum of item points (maximum 27)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
