<x-calc.page
    title="Goat Gestation Calculator - SolveKit"
    description="Free goat gestation calculator: due date, normal kidding window and a dated pregnancy timeline from the breeding date."
    lede="Work out the kidding date and pregnancy timeline from the breeding date."
    about="Goats kid about 150 days after breeding, normally between days 145 and 155. Small breeds such as Nigerian Dwarf may kid a few days earlier."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['goat'])->all()]"
    :how-to="[
        ['name' => 'Breeding date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are goats pregnant?', 'answer' => 'About 150 days, roughly five months.'],
        ['question' => 'When can I confirm pregnancy?', 'answer' => 'By ultrasound from about day 30, or a blood test from about day 30.'],
        ['question' => 'When do kids grow fastest?', 'answer' => 'In the last six weeks, when good feed matters most.'],
    ]"
>
    <x-calc.field name="date" label="Breeding date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Kidding date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(143)->toDateString()],
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
            <li>due date = breeding date + 150 days</li>
            <li>normal range: day 145 to day 155</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
