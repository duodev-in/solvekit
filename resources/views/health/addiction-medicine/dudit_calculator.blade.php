<x-calc.page
    title="DUDIT Calculator - SolveKit"
    description="Free DUDIT calculator: the Drug Use Disorders Identification Test, 11 questions scored 0–44 with the cut-offs for men and women."
    lede="Take the DUDIT drug-use screen."
    about="DUDIT (Berman et al. 2005) screens for drug-related problems: 6 or more for men or 2 or more for women suggests drug-related problems, and 25 or more probable dependence. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11'], 'data' => ['score' => config('health_data.scores.dudit')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does the default answer set score?', 'answer' => '2 of 44: At or above the cut-off for women (2–5).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="How often do you use drugs other than alcohol?" :options="['o0' => 'Never (0 points)', 'o1' => 'Once a month or less often (1 point)', 'o2' => '2–4 times a month (2 points)', 'o3' => '2–3 times a week (3 points)', 'o4' => '4 times a week or more often (4 points)']" selected="o1" />
        <x-calc.select name="q2" label="Do you use more than one type of drug on the same occasion?" :options="['o0' => 'Never (0 points)', 'o1' => 'Once a month or less often (1 point)', 'o2' => '2–4 times a month (2 points)', 'o3' => '2–3 times a week (3 points)', 'o4' => '4 times a week or more often (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q3" label="How many times do you take drugs on a typical day when you use drugs?" :options="['o0' => '0 (0 points)', 'o1' => '1–2 (1 point)', 'o2' => '3–4 (2 points)', 'o3' => '5–6 (3 points)', 'o4' => '7 or more (4 points)']" selected="o1" />
        <x-calc.select name="q4" label="How often are you influenced heavily by drugs?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less often than once a month (1 point)', 'o2' => 'Every month (2 points)', 'o3' => 'Every week (3 points)', 'o4' => 'Daily or almost every day (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q5" label="Over the past year, has your longing for drugs been so strong that you could not resist it?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less often than once a month (1 point)', 'o2' => 'Every month (2 points)', 'o3' => 'Every week (3 points)', 'o4' => 'Daily or almost every day (4 points)']" selected="o0" />
        <x-calc.select name="q6" label="Over the past year, have you been unable to stop taking drugs once you started?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less often than once a month (1 point)', 'o2' => 'Every month (2 points)', 'o3' => 'Every week (3 points)', 'o4' => 'Daily or almost every day (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q7" label="Over the past year, have you taken drugs and then neglected to do something you should have done?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less often than once a month (1 point)', 'o2' => 'Every month (2 points)', 'o3' => 'Every week (3 points)', 'o4' => 'Daily or almost every day (4 points)']" selected="o0" />
        <x-calc.select name="q8" label="Over the past year, have you needed to take a drug the morning after heavy drug use the day before?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less often than once a month (1 point)', 'o2' => 'Every month (2 points)', 'o3' => 'Every week (3 points)', 'o4' => 'Daily or almost every day (4 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q9" label="Over the past year, have you had guilt feelings or a bad conscience because you used drugs?" :options="['o0' => 'Never (0 points)', 'o1' => 'Less often than once a month (1 point)', 'o2' => 'Every month (2 points)', 'o3' => 'Every week (3 points)', 'o4' => 'Daily or almost every day (4 points)']" selected="o0" />
        <x-calc.select name="q10" label="Have you or anyone else been hurt (mentally or physically) because you used drugs?" :options="['o0' => 'No (0 points)', 'o1' => 'Yes, but not in the last year (2 points)', 'o2' => 'Yes, during the last year (4 points)']" selected="o0" />
    </div>

    <x-calc.select name="q11" label="Has a relative, friend, doctor or nurse been worried about your drug use or said you should stop?" :options="['o0' => 'No (0 points)', 'o1' => 'Yes, but not in the last year (2 points)', 'o2' => 'Yes, during the last year (4 points)']" selected="o0" />

    <x-calc.result label="DUDIT" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o1', 'q2' => 'o0', 'q3' => 'o1', 'q4' => 'o0', 'q5' => 'o0', 'q6' => 'o0', 'q7' => 'o0', 'q8' => 'o0', 'q9' => 'o0', 'q10' => 'o0', 'q11' => 'o0'],
        'Highest' => ['q1' => 'o4', 'q2' => 'o4', 'q3' => 'o4', 'q4' => 'o4', 'q5' => 'o4', 'q6' => 'o4', 'q7' => 'o4', 'q8' => 'o4', 'q9' => 'o4', 'q10' => 'o2', 'q11' => 'o2'],
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
            <li>DUDIT: sum of item points (maximum 44)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
