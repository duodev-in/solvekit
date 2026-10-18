<x-calc.page
    title="The Witcher Calculator - SolveKit"
    description="Free Witcher calculator: how long it takes to read Andrzej Sapkowski's Witcher saga and watch the Netflix series, at your reading pace."
    lede="See how long it takes to read and watch The Witcher."
    about="Page counts are for the Orbit English editions (Open Library records); time = pages ÷ your pace. Series runtimes add up each episode's runtime from TVmaze: seasons 1–4 of The Witcher (2019–2025), Blood Origin (2022) and the animated films Nightmare of the Wolf and Sirens of the Deep. The games are left out: their length varies too much with play style."
    :calc="['engine' => 'ev-fun', 'tool' => 'witcher', 'fields' => ['saga', 'storms', 'pace', 'series', 'blood_origin', 'anime', 'per_day'], 'data' => collect(config('everyday_data'))->only(['witcher_books', 'witcher_screen'])->all()]"
    :how-to="[
        ['name' => 'Choose books and series', 'text' => 'Tick what you want to finish.'],
        ['name' => 'Set your reading pace', 'text' => 'Pages an hour.'],
    ]"
    :faqs="[
        ['question' => 'How long are the Witcher books?', 'answer' => 'About 2,964 pages for the seven-book saga in the Orbit editions: 74 hours at 40 pages an hour.'],
        ['question' => 'How long is the Netflix series?', 'answer' => 'About 30 hours for seasons 1–4.'],
        ['question' => 'What order should I read them in?', 'answer' => 'The Last Wish, Sword of Destiny, then the five novels; Season of Storms can come any time after.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="saga" label="The saga (7 books)" :checked="true" />
        <x-calc.checkbox name="storms" label="Season of Storms" :checked="false" />
        <x-calc.field name="pace" label="Reading pace" value="40" min="5" max="150" suffix="pages/hour" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.checkbox name="series" label="The Witcher, seasons 1–4" :checked="true" />
        <x-calc.checkbox name="blood_origin" label="Blood Origin" :checked="false" />
        <x-calc.checkbox name="anime" label="The two animated films" :checked="false" />
    </div>

    <x-calc.field name="per_day" label="Hours a day (optional)" value="2" min="0.25" max="24" step="0.25" />

    <x-calc.result label="Time to finish" />

    <x-calc.options :decimals="false" :examples="[
        'Saga and series' => ['saga' => true, 'storms' => false, 'pace' => 40, 'series' => true, 'blood_origin' => false, 'anime' => false, 'per_day' => 2],
        'Everything' => ['saga' => true, 'storms' => true, 'pace' => 45, 'series' => true, 'blood_origin' => true, 'anime' => true, 'per_day' => 3],
        'Series only' => ['saga' => false, 'storms' => false, 'pace' => 40, 'series' => true, 'blood_origin' => true, 'anime' => false, 'per_day' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'reading' => ['label' => 'Reading'],
            'watching' => ['label' => 'Watching'],
            'days' => ['label' => 'Days'],
        ]" />
        <x-calc.quick-ref heading="Books and shows" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = pages ÷ pace + Σ runtimes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
