<x-calc.page
    title="Sheep Gestation Calculator - SolveKit"
    description="Free sheep gestation calculator: due date, normal lambing window and a dated pregnancy timeline from the breeding date."
    lede="Work out the lambing date and pregnancy timeline from the breeding date."
    about="Ewes lamb about 147 days after mating, normally between days 142 and 152. With a raddled ram the mark color shows the mating date for each ewe."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['sheep'])->all()]"
    :how-to="[
        ['name' => 'Breeding date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are sheep pregnant?', 'answer' => 'About 147 days, roughly five months.'],
        ['question' => 'When is scanning done?', 'answer' => 'Between about days 45 and 90, when lambs can be counted.'],
        ['question' => 'Why feed more in late pregnancy?', 'answer' => 'About 70% of lamb growth happens in the last six weeks.'],
    ]"
>
    <x-calc.field name="date" label="Breeding date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Lambing date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(140)->toDateString()],
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
            <li>due date = breeding date + 147 days</li>
            <li>normal range: day 142 to day 152</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
