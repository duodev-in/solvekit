<x-calc.page
    title="Dog Pregnancy Calculator - SolveKit"
    description="Free dog pregnancy calculator: due date, normal whelping window and a dated pregnancy timeline from the breeding date."
    lede="Work out the whelping date and pregnancy timeline from the breeding or ovulation date."
    about="Dogs whelp about 63 days after ovulation. Timed from a mating the range is wider, 58 to 68 days, because sperm can live for several days before the eggs are ready. If your vet timed ovulation with progesterone tests, choose ovulation for a much narrower window."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['basis', 'date'], 'data' => collect(config('biology_data.gestation'))->only(['dog'])->all()]"
    :how-to="[
        ['name' => 'Breeding or ovulation date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are dogs pregnant?', 'answer' => 'About 63 days from ovulation, or 58 to 68 days from mating.'],
        ['question' => 'When can a vet confirm pregnancy?', 'answer' => 'By ultrasound from about day 25, or by X-ray from about day 45, which also counts the puppies.'],
        ['question' => 'What are the signs of whelping?', 'answer' => 'Nesting, restlessness and a drop in rectal temperature below about 99 °F (37.2 °C), usually within 24 hours of birth.'],
    ]"
>
    <x-calc.segmented name="basis" legend="Timed from" :options="['breeding' => 'Breeding', 'ovulation' => 'Ovulation']" selected="breeding" />

    <x-calc.field name="date" label="Breeding or ovulation date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Whelping date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(56)->toDateString()],
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
            <li>due date = breeding or ovulation date + 63 days</li>
            <li>normal range: day 58 to day 68</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
