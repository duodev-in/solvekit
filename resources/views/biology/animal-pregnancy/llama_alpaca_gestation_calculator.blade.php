<x-calc.page
    title="Llama and Alpaca Gestation Calculator - SolveKit"
    description="Free llama and alpaca gestation calculator: due date, normal birth window and a dated pregnancy timeline from the breeding date."
    lede="Work out the birth date and pregnancy timeline from the breeding date."
    about="Llamas and alpacas are pregnant for about 11.5 months, around 345 to 350 days, with a normal range of about 335 to 360 days. Females ovulate in response to mating, so the breeding date is a good start point."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['species', 'date'], 'data' => collect(config('biology_data.gestation'))->only(['llama', 'alpaca'])->all()]"
    :how-to="[
        ['name' => 'Breeding date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are alpacas pregnant?', 'answer' => 'About 345 days, normally 335 to 360.'],
        ['question' => 'What is a spit-off test?', 'answer' => 'A pregnant female spits at and refuses the male, usually from about 1 to 3 weeks after mating.'],
        ['question' => 'When are crias born?', 'answer' => 'Most are born in the morning, giving them time to dry before night.'],
    ]"
>
    <x-calc.select name="species" label="Species" :options="collect(config('biology_data.gestation'))->only(['llama', 'alpaca'])->map(fn ($item) => $item['name'])->all()" selected="llama" />

    <x-calc.field name="date" label="Breeding date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Birth date" />

    <x-calc.options :decimals="false" :examples="[
        'Llama, bred 30 days ago' => ['species' => 'llama', 'date' => now()->subDays(30)->toDateString()],
        'Alpaca, bred 30 days ago' => ['species' => 'alpaca', 'date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['species' => 'llama', 'date' => now()->subDays(343)->toDateString()],
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
            <li>due date = breeding date + 350 days</li>
            <li>normal range: day 335 to day 360</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
