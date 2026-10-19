<x-calc.page
    title="EPDS Calculator - SolveKit"
    description="Free EPDS calculator: the Edinburgh Postnatal Depression Scale, ten questions about the past week for depression during and after pregnancy, with support if you have thoughts of self-harm."
    lede="Take the Edinburgh Postnatal Depression Scale."
    about="The EPDS (Cox, Holden & Sagovsky 1987) is used in pregnancy and after birth. Scores of 10 or more suggest possible depression and 13 or more probable depression; any answer other than “never” to question 10 needs prompt support. Partners can use it too. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10'], 'data' => ['score' => config('health_data.scores.epds')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does the default (all best answers) score?', 'answer' => '0 of 30: Depression not likely (0–9).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="In the past 7 days: I have been able to laugh and see the funny side of things" :options="['o0' => 'As much as I always could (0 points)', 'o1' => 'Not quite so much now (1 point)', 'o2' => 'Definitely not so much now (2 points)', 'o3' => 'Not at all (3 points)']" selected="o0" />
        <x-calc.select name="q2" label="In the past 7 days: I have looked forward with enjoyment to things" :options="['o0' => 'As much as I ever did (0 points)', 'o1' => 'Rather less than I used to (1 point)', 'o2' => 'Definitely less than I used to (2 points)', 'o3' => 'Hardly at all (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q3" label="In the past 7 days: I have blamed myself unnecessarily when things went wrong" :options="['o0' => 'Yes, most of the time (3 points)', 'o1' => 'Yes, some of the time (2 points)', 'o2' => 'Not very often (1 point)', 'o3' => 'No, never (0 points)']" selected="o3" />
        <x-calc.select name="q4" label="In the past 7 days: I have been anxious or worried for no good reason" :options="['o0' => 'No, not at all (0 points)', 'o1' => 'Hardly ever (1 point)', 'o2' => 'Yes, sometimes (2 points)', 'o3' => 'Yes, very often (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q5" label="In the past 7 days: I have felt scared or panicky for no very good reason" :options="['o0' => 'Yes, quite a lot (3 points)', 'o1' => 'Yes, sometimes (2 points)', 'o2' => 'No, not much (1 point)', 'o3' => 'No, not at all (0 points)']" selected="o3" />
        <x-calc.select name="q6" label="In the past 7 days: Things have been getting on top of me" :options="['o0' => 'Yes, most of the time I haven’t been able to cope at all (3 points)', 'o1' => 'Yes, sometimes I haven’t been coping as well as usual (2 points)', 'o2' => 'No, most of the time I have coped quite well (1 point)', 'o3' => 'No, I have been coping as well as ever (0 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q7" label="In the past 7 days: I have been so unhappy that I have had difficulty sleeping" :options="['o0' => 'Yes, most of the time (3 points)', 'o1' => 'Yes, sometimes (2 points)', 'o2' => 'Not very often (1 point)', 'o3' => 'No, not at all (0 points)']" selected="o3" />
        <x-calc.select name="q8" label="In the past 7 days: I have felt sad or miserable" :options="['o0' => 'Yes, most of the time (3 points)', 'o1' => 'Yes, quite often (2 points)', 'o2' => 'Not very often (1 point)', 'o3' => 'No, not at all (0 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q9" label="In the past 7 days: I have been so unhappy that I have been crying" :options="['o0' => 'Yes, most of the time (3 points)', 'o1' => 'Yes, quite often (2 points)', 'o2' => 'Only occasionally (1 point)', 'o3' => 'No, never (0 points)']" selected="o3" />
        <x-calc.select name="q10" label="In the past 7 days: The thought of harming myself has occurred to me" :options="['o0' => 'Yes, quite often (3 points)', 'o1' => 'Sometimes (2 points)', 'o2' => 'Hardly ever (1 point)', 'o3' => 'Never (0 points)']" selected="o3" />
    </div>

    <x-calc.result label="Edinburgh Postnatal Depression Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o0', 'q2' => 'o0', 'q3' => 'o3', 'q4' => 'o0', 'q5' => 'o3', 'q6' => 'o3', 'q7' => 'o3', 'q8' => 'o3', 'q9' => 'o3', 'q10' => 'o3'],
        'Highest' => ['q1' => 'o3', 'q2' => 'o3', 'q3' => 'o0', 'q4' => 'o3', 'q5' => 'o0', 'q6' => 'o0', 'q7' => 'o0', 'q8' => 'o0', 'q9' => 'o0', 'q10' => 'o0'],
        'Struggling' => ['q1' => 'o2', 'q2' => 'o2', 'q3' => 'o1', 'q4' => 'o2', 'q5' => 'o1', 'q6' => 'o1', 'q7' => 'o1', 'q8' => 'o1', 'q9' => 'o2', 'q10' => 'o3'],
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
            <li>Edinburgh Postnatal Depression Scale: sum of item points (maximum 30)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
