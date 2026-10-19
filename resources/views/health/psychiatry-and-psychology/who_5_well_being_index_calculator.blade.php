<x-calc.page
    title="WHO-5 Well-Being Index Calculator - SolveKit"
    description="Free WHO-5 calculator: five questions on mood, energy and interest over the last two weeks, scored 0–25 and as a percentage."
    lede="Measure your well-being with the WHO-5."
    about="The WHO-5 Well-Being Index (WHO 1998) is one of the most widely used well-being questionnaires. The raw score (0–25) is multiplied by 4 for a percentage; under 13 (52%) suggests poor well-being and 7 or less (28%) possible depression, which is worth discussing with a doctor (Topp et al. 2015). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['q1', 'q2', 'q3', 'q4', 'q5'], 'data' => ['score' => config('health_data.scores.who5')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does “more than half of the time” on every item score?', 'answer' => '15 of 25 raw (Good well-being (raw 13–25, 52–100%)).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q1" label="Over the last 2 weeks: i have felt cheerful and in good spirits" :options="['o0' => 'At no time (0 points)', 'o1' => 'Some of the time (1 point)', 'o2' => 'Less than half of the time (2 points)', 'o3' => 'More than half of the time (3 points)', 'o4' => 'Most of the time (4 points)', 'o5' => 'All of the time (5 points)']" selected="o3" />
        <x-calc.select name="q2" label="Over the last 2 weeks: i have felt calm and relaxed" :options="['o0' => 'At no time (0 points)', 'o1' => 'Some of the time (1 point)', 'o2' => 'Less than half of the time (2 points)', 'o3' => 'More than half of the time (3 points)', 'o4' => 'Most of the time (4 points)', 'o5' => 'All of the time (5 points)']" selected="o3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="q3" label="Over the last 2 weeks: i have felt active and vigorous" :options="['o0' => 'At no time (0 points)', 'o1' => 'Some of the time (1 point)', 'o2' => 'Less than half of the time (2 points)', 'o3' => 'More than half of the time (3 points)', 'o4' => 'Most of the time (4 points)', 'o5' => 'All of the time (5 points)']" selected="o3" />
        <x-calc.select name="q4" label="Over the last 2 weeks: i woke up feeling fresh and rested" :options="['o0' => 'At no time (0 points)', 'o1' => 'Some of the time (1 point)', 'o2' => 'Less than half of the time (2 points)', 'o3' => 'More than half of the time (3 points)', 'o4' => 'Most of the time (4 points)', 'o5' => 'All of the time (5 points)']" selected="o3" />
    </div>

    <x-calc.select name="q5" label="Over the last 2 weeks: my daily life has been filled with things that interest me" :options="['o0' => 'At no time (0 points)', 'o1' => 'Some of the time (1 point)', 'o2' => 'Less than half of the time (2 points)', 'o3' => 'More than half of the time (3 points)', 'o4' => 'Most of the time (4 points)', 'o5' => 'All of the time (5 points)']" selected="o3" />

    <x-calc.result label="WHO-5 Well-Being Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['q1' => 'o3', 'q2' => 'o3', 'q3' => 'o3', 'q4' => 'o3', 'q5' => 'o3'],
        'Highest' => ['q1' => 'o5', 'q2' => 'o5', 'q3' => 'o5', 'q4' => 'o5', 'q5' => 'o5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'percent' => ['label' => 'Percentage score'],
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>WHO-5 Well-Being Index: sum of item points (maximum 25)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
