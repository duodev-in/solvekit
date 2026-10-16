<x-calc.page
    title="Swine Gestation Calculator - SolveKit"
    description="Free swine gestation calculator: due date, normal farrowing window and a dated pregnancy timeline from the breeding date."
    lede="Work out the farrowing date and pregnancy timeline from the breeding date."
    about="Sows farrow about 114 days after breeding, remembered as three months, three weeks and three days. Most farrow between days 111 and 117."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['pig'])->all()]"
    :how-to="[
        ['name' => 'Breeding date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are pigs pregnant?', 'answer' => 'About 114 days: 3 months, 3 weeks and 3 days.'],
        ['question' => 'How do I know a sow is pregnant?', 'answer' => 'No return to heat around day 21, then ultrasound from about day 24.'],
        ['question' => 'When should she move to the farrowing pen?', 'answer' => 'About 5 days before the due date.'],
    ]"
>
    <x-calc.field name="date" label="Breeding date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Farrowing date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(107)->toDateString()],
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
            <li>due date = breeding date + 114 days</li>
            <li>normal range: day 111 to day 117</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
