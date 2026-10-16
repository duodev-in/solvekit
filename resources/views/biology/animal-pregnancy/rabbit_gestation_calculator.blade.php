<x-calc.page
    title="Rabbit Gestation Calculator - SolveKit"
    description="Free rabbit gestation calculator: due date, normal kindling window and a dated pregnancy timeline from the breeding date."
    lede="Work out the kindling date and pregnancy timeline from the mating date."
    about="Does kindle about 31 days after mating, normally between days 28 and 35. Put the nest box in around day 28: earlier and she may soil it, later and she may kindle on the cage floor."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['rabbit'])->all()]"
    :how-to="[
        ['name' => 'Mating date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are rabbits pregnant?', 'answer' => 'About 31 days, normally 28 to 35.'],
        ['question' => 'When do I add the nest box?', 'answer' => 'Around day 28.'],
        ['question' => 'When can I tell she is pregnant?', 'answer' => 'Kits can be felt by gentle palpation from about days 10 to 14.'],
    ]"
>
    <x-calc.field name="date" label="Mating date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Kindling date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(24)->toDateString()],
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
            <li>due date = mating date + 31 days</li>
            <li>normal range: day 28 to day 35</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
