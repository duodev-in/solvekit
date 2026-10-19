<x-calc.page
    title="Fatigue Severity Scale Calculator - SolveKit"
    description="Free Fatigue Severity Scale calculator: nine statements about how fatigue affects you, rated 1–7; an average of 4 or more means significant fatigue."
    lede="Measure how fatigue affects you."
    about="The Fatigue Severity Scale (Krupp et al. 1989) is used in multiple sclerosis, lupus, sleep disorders and other conditions. Each statement is rated from 1 (strongly disagree) to 7 (strongly agree); an average of 4 or more (total 36+) suggests significant fatigue. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9'], 'data' => ['score' => config('health_data.scores.fss')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does the default answer set give?', 'answer' => '27 of 63: Below the fatigue threshold (average under 4).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="During the past week: my motivation is lower when i am fatigued" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
        <x-calc.select name="q2" label="During the past week: exercise brings on my fatigue" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q3" label="During the past week: i am easily fatigued" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
        <x-calc.select name="q4" label="During the past week: fatigue interferes with my physical functioning" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q5" label="During the past week: fatigue causes frequent problems for me" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
        <x-calc.select name="q6" label="During the past week: my fatigue prevents sustained physical functioning" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q7" label="During the past week: fatigue interferes with carrying out certain duties and responsibilities" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
        <x-calc.select name="q8" label="During the past week: fatigue is among my most disabling symptoms" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />
    </div>

    <x-calc.select name="q9" label="During the past week: fatigue interferes with my work, family, or social life" :options="['o0' => '1: strongly disagree (1 point)', 'o1' => '2 (2 points)', 'o2' => '3 (3 points)', 'o3' => '4 (4 points)', 'o4' => '5 (5 points)', 'o5' => '6 (6 points)', 'o6' => '7: strongly agree (7 points)']" selected="o2" />

    <x-calc.result label="Fatigue Severity Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o2', 'q2' => 'o2', 'q3' => 'o2', 'q4' => 'o2', 'q5' => 'o2', 'q6' => 'o2', 'q7' => 'o2', 'q8' => 'o2', 'q9' => 'o2'],
        'Highest' => ['q1' => 'o6', 'q2' => 'o6', 'q3' => 'o6', 'q4' => 'o6', 'q5' => 'o6', 'q6' => 'o6', 'q7' => 'o6', 'q8' => 'o6', 'q9' => 'o6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mean' => ['label' => 'Average per item'],
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Fatigue Severity Scale: sum of item points (maximum 63)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
