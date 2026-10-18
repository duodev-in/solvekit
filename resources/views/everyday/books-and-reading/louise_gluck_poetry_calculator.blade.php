<x-calc.page
    title="Louise Glück Poetry Calculator - SolveKit"
    description="Free Louise Glück poetry calculator: how long it takes to read her poetry collections, from Firstborn to Winter Recipes from the Collective, from their page counts and your reading pace."
    lede="Work out how long it takes to read Louise Glück's poetry."
    about="Louise Glück (1943–2023) won the 2020 Nobel Prize in Literature and published 13 collections of poems, gathered with Winter Recipes from the Collective after Poems 1962–2012. Page counts are for the first US editions (Open Library records); the time = pages ÷ your pace. Poetry rewards slow reading, so 15–30 pages an hour is a typical pace."
    :calc="['engine' => 'ev-books', 'tool' => 'gluck', 'fields' => ['collection', 'pace', 'minutes'], 'data' => collect(config('everyday_data'))->only(['gluck', 'gluck_collected'])->all()]"
    :how-to="[
        ['name' => 'Choose a collection', 'text' => 'Or all of them.'],
        ['name' => 'Set your pace', 'text' => 'Pages an hour, and minutes a day.'],
    ]"
    :faqs="[
        ['question' => 'How many poetry collections did Louise Glück publish?', 'answer' => '13, from Firstborn (1968) to Winter Recipes from the Collective (2021).'],
        ['question' => 'How long does The Wild Iris take to read?', 'answer' => 'Its 63 pages take about 3 hours at 20 pages an hour.'],
        ['question' => 'Which book collects her poems?', 'answer' => 'Poems 1962–2012 (634 pages) gathers the first eleven collections.'],
    ]"
>
    <x-calc.select name="collection" label="Collection" :options="['all' => 'All 13 collections', 'collected' => 'Poems 1962–2012 (collected)'] + collect(config('everyday_data.gluck'))->mapWithKeys(fn ($b) => [$b[0] => $b[1].' ('.$b[2].')'])->all()" selected="all" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pace" label="Your pace" value="20" min="1" step="1" suffix="pages/hour" />
        <x-calc.field name="minutes" label="Minutes a day (optional)" value="30" min="0" step="5" />
    </div>

    <x-calc.result label="Time to read" />

    <x-calc.options :decimals="false" :examples="[
        'All collections' => ['collection' => 'all', 'pace' => 20, 'minutes' => 30],
        'The Wild Iris' => ['collection' => 'wild_iris', 'pace' => 20, 'minutes' => 30],
        'Poems 1962–2012' => ['collection' => 'collected', 'pace' => 25, 'minutes' => 45],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pages' => ['label' => 'Pages'],
            'hours' => ['label' => 'Hours'],
            'days' => ['label' => 'Finish'],
        ]" />
        <x-calc.quick-ref heading="Collections" name="books" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = pages ÷ pages per hour</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
