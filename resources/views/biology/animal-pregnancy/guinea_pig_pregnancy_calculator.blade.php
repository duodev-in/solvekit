<x-calc.page
    title="Guinea Pig Pregnancy Calculator - SolveKit"
    description="Free guinea pig pregnancy calculator: due date, normal birth window and a dated pregnancy timeline from the breeding date."
    lede="Work out the birth date and pregnancy timeline from the mating date."
    about="Guinea pigs are pregnant for about 68 days, normally 59 to 72; larger litters tend to arrive sooner. Pups are born fully furred with open eyes."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['guinea_pig'])->all()]"
    :how-to="[
        ['name' => 'Mating date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are guinea pigs pregnant?', 'answer' => 'About 68 days, normally 59 to 72.'],
        ['question' => 'Is pregnancy risky for guinea pigs?', 'answer' => 'It can be; a sow first bred after about 7 months may have birth problems, so ask a vet.'],
        ['question' => 'Can she get pregnant straight after birth?', 'answer' => 'Yes, within hours, so separate the boar before the due date.'],
    ]"
>
    <x-calc.field name="date" label="Mating date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Birth date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(61)->toDateString()],
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
            <li>due date = mating date + 68 days</li>
            <li>normal range: day 59 to day 72</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
