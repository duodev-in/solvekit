<x-calc.page
    title="Cat Pregnancy Calculator - SolveKit"
    description="Free cat pregnancy calculator: due date, normal kittening window and a dated pregnancy timeline from the breeding date."
    lede="Work out the kittening date and pregnancy timeline from the mating date."
    about="Cats are pregnant for about 63 to 67 days, and normal births happen from about day 61 to day 72. Queens often mate several times, so date the pregnancy from the first mating you know of."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['cat'])->all()]"
    :how-to="[
        ['name' => 'Mating date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are cats pregnant?', 'answer' => 'About 65 days on average, normally 61 to 72 days.'],
        ['question' => 'What is pinking up?', 'answer' => 'From about day 15 the nipples turn pink and enlarge, one of the first signs.'],
        ['question' => 'When will she start nesting?', 'answer' => 'Usually in the last week; offer a quiet, warm box.'],
    ]"
>
    <x-calc.field name="date" label="Mating date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Kittening date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(58)->toDateString()],
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
            <li>due date = mating date + 65 days</li>
            <li>normal range: day 61 to day 72</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
