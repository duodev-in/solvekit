<x-calc.page
    title="Pediatric Epworth Sleepiness Scale Calculator - SolveKit"
    description="Free pediatric Epworth calculator: the Epworth Sleepiness Scale for Children and Adolescents (ESS-CHAD), eight situations rated 0–3."
    lede="Measure daytime sleepiness in children."
    about="The ESS-CHAD (Janssen et al. 2017) adapts the adult scale to school-age children and teenagers, with situations like sitting in a classroom or eating a meal. It has no single validated cut-off; scores above 10 are often treated as excessive, as in adults. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['reading', 'tv', 'class', 'car', 'lying', 'talking', 'lunch', 'meal'], 'data' => ['score' => config('health_data.scores.ess_chad')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a slight chance in every situation score?', 'answer' => '8 of 24.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="reading" label="Sitting and reading" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="tv" label="Sitting and watching TV or a video" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="class" label="Sitting in a classroom at school during the morning" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="car" label="Sitting and riding in a car or bus for about half an hour" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="lying" label="Lying down to rest or nap in the afternoon" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="talking" label="Sitting and talking to someone" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="lunch" label="Sitting quietly by yourself after lunch" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="meal" label="Sitting and eating a meal" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <x-calc.result label="Epworth Sleepiness Scale for Children and Adolescents" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['reading' => 'o0', 'tv' => 'o0', 'class' => 'o0', 'car' => 'o0', 'lying' => 'o0', 'talking' => 'o0', 'lunch' => 'o0', 'meal' => 'o0'],
        'Highest' => ['reading' => 'o3', 'tv' => 'o3', 'class' => 'o3', 'car' => 'o3', 'lying' => 'o3', 'talking' => 'o3', 'lunch' => 'o3', 'meal' => 'o3'],
        'All slight' => ['reading' => 'o1', 'tv' => 'o1', 'class' => 'o1', 'car' => 'o1', 'lying' => 'o1', 'talking' => 'o1', 'lunch' => 'o1', 'meal' => 'o1'],
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
            <li>Epworth Sleepiness Scale for Children and Adolescents: sum of item points (maximum 24)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
