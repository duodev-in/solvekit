<x-calc.page
    title="Cow Gestation Calculator - SolveKit"
    description="Free cow gestation calculator: due date, normal calving window and a dated pregnancy timeline from the breeding date."
    lede="Work out the calving date and pregnancy timeline from the breeding date."
    about="Cows carry calves for about 283 days, a little over nine months. Breed and calf sex shift it by a few days: some beef breeds such as Brahman run longer, and bull calves tend to be carried slightly longer."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['cow'])->all()]"
    :how-to="[
        ['name' => 'Breeding date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long is a cow pregnant?', 'answer' => 'About 283 days, usually 279 to 287.'],
        ['question' => 'When can pregnancy be confirmed?', 'answer' => 'By ultrasound from about day 28 or rectal palpation from about day 35.'],
        ['question' => 'When should a dairy cow be dried off?', 'answer' => 'Usually about 60 days before calving.'],
    ]"
>
    <x-calc.field name="date" label="Breeding date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Calving date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(276)->toDateString()],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'earliest' => ['label' => 'Earliest normal date'],
            'latest' => ['label' => 'Latest normal date'],
            'length' => ['label' => 'Pregnancy length'],
            'progress' => ['label' => 'Progress'],
        ]" />
        <x-calc.quick-ref heading="Timeline" name="timeline" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>due date = breeding date + 283 days</li>
            <li>normal range: day 279 to day 287</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
