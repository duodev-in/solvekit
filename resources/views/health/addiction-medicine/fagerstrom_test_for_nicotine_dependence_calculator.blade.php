<x-calc.page
    title="Fagerstrom Test for Nicotine Dependence Calculator - SolveKit"
    description="Free Fagerström test calculator: six questions on smoking habits, scored 0–10 for nicotine dependence."
    lede="Measure nicotine dependence."
    about="The Fagerström Test for Nicotine Dependence (Heatherton et al. 1991) asks how soon you smoke after waking, how many a day and four yes/no questions. Scores of 6 or more mean high dependence; stop-smoking medicine and support help most. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['first', 'forbidden', 'hate', 'per_day', 'morning', 'ill'], 'data' => ['score' => config('health_data.scores.fagerstrom')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does the default answer set score?', 'answer' => '2 of 10: Very low dependence (0–2).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="first" label="How soon after you wake up do you smoke your first cigarette?" :options="['o0' => 'Within 5 minutes (3 points)', 'o1' => '6–30 minutes (2 points)', 'o2' => '31–60 minutes (1 point)', 'o3' => 'After 60 minutes (0 points)']" selected="o2" />
        <x-calc.checkbox name="forbidden" label="Do you find it difficult not to smoke in places where it is forbidden?" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="hate" label="Which cigarette would you hate most to give up?" :options="['o0' => 'The first one in the morning (1 point)', 'o1' => 'Any other (0 points)']" selected="o1" />
        <x-calc.select name="per_day" label="How many cigarettes a day do you smoke?" :options="['o0' => '10 or fewer (0 points)', 'o1' => '11–20 (1 point)', 'o2' => '21–30 (2 points)', 'o3' => '31 or more (3 points)']" selected="o1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="morning" label="Do you smoke more in the first hours after waking than during the rest of the day?" :checked="false" />
        <x-calc.checkbox name="ill" label="Do you smoke even when you are so ill that you are in bed most of the day?" :checked="false" />
    </div>

    <x-calc.result label="Fagerström Test for Nicotine Dependence" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['first' => 'o2', 'forbidden' => false, 'hate' => 'o1', 'per_day' => 'o1', 'morning' => false, 'ill' => false],
        'Highest' => ['first' => 'o0', 'forbidden' => true, 'hate' => 'o0', 'per_day' => 'o3', 'morning' => true, 'ill' => true],
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
            <li>Fagerström Test for Nicotine Dependence: sum of item points (maximum 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
