<x-calc.page
    title="HSI Calculator — Heaviness of Smoking Index - SolveKit"
    description="Free Heaviness of Smoking Index calculator: two questions (time to first cigarette and cigarettes a day), scored 0–6."
    lede="Score the Heaviness of Smoking Index."
    about="The HSI (Heatherton et al. 1989) uses two Fagerström questions that predict dependence well: 0–1 low, 2–4 moderate and 5–6 high. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['first', 'per_day'], 'data' => ['score' => config('health_data.scores.hsi')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does smoking within 5 minutes of waking and 21–30 a day score?', 'answer' => '5 of 6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="first" label="How soon after waking do you smoke your first cigarette?" :options="['o0' => 'Within 5 minutes (3 points)', 'o1' => '6–30 minutes (2 points)', 'o2' => '31–60 minutes (1 point)', 'o3' => 'After 60 minutes (0 points)']" selected="o2" />
        <x-calc.select name="per_day" label="How many cigarettes a day do you smoke?" :options="['o0' => '10 or fewer (0 points)', 'o1' => '11–20 (1 point)', 'o2' => '21–30 (2 points)', 'o3' => '31 or more (3 points)']" selected="o1" />
    </div>

    <x-calc.result label="Heaviness of Smoking Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['first' => 'o2', 'per_day' => 'o1'],
        'Highest' => ['first' => 'o0', 'per_day' => 'o3'],
        'Heavy' => ['first' => 'o0', 'per_day' => 'o2'],
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
            <li>Heaviness of Smoking Index: sum of item points (maximum 6)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
