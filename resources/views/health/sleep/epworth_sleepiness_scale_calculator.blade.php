<x-calc.page
    title="Epworth Sleepiness Scale Calculator - SolveKit"
    description="Free Epworth Sleepiness Scale calculator: rate your chance of dozing in eight everyday situations to measure daytime sleepiness (0–24)."
    lede="Measure your daytime sleepiness."
    about="The Epworth Sleepiness Scale (Johns 1991) asks how likely you are to doze off in eight situations, from 0 (would never doze) to 3 (high chance). Totals of 11 or more suggest excessive daytime sleepiness, which can come from too little sleep, sleep apnoea, narcolepsy or medicines. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['reading', 'tv', 'public', 'passenger', 'lying', 'talking', 'lunch', 'traffic'], 'data' => ['score' => config('health_data.scores.epworth')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does a moderate chance in every situation score?', 'answer' => '16 of 24: Severe excessive daytime sleepiness (16–24).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="reading" label="Sitting and reading" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="tv" label="Watching TV" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="public" label="Sitting inactive in a public place (a theatre or a meeting)" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="passenger" label="As a passenger in a car for an hour without a break" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="lying" label="Lying down to rest in the afternoon when circumstances permit" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="talking" label="Sitting and talking to someone" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="lunch" label="Sitting quietly after a lunch without alcohol" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
        <x-calc.select name="traffic" label="In a car, while stopped for a few minutes in traffic" :options="['o0' => 'Would never doze (0 points)', 'o1' => 'Slight chance (1 point)', 'o2' => 'Moderate chance (2 points)', 'o3' => 'High chance (3 points)']" selected="o0" />
    </div>

    <x-calc.result label="Epworth Sleepiness Scale" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['reading' => 'o0', 'tv' => 'o0', 'public' => 'o0', 'passenger' => 'o0', 'lying' => 'o0', 'talking' => 'o0', 'lunch' => 'o0', 'traffic' => 'o0'],
        'Highest' => ['reading' => 'o3', 'tv' => 'o3', 'public' => 'o3', 'passenger' => 'o3', 'lying' => 'o3', 'talking' => 'o3', 'lunch' => 'o3', 'traffic' => 'o3'],
        'All moderate' => ['reading' => 'o2', 'tv' => 'o2', 'public' => 'o2', 'passenger' => 'o2', 'lying' => 'o2', 'talking' => 'o2', 'lunch' => 'o2', 'traffic' => 'o2'],
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
            <li>Epworth Sleepiness Scale: sum of item points (maximum 24)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
