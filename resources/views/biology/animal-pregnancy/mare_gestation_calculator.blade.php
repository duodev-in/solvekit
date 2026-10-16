<x-calc.page
    title="Mare Gestation Calculator - SolveKit"
    description="Free mare gestation calculator: due date, normal foaling window and a dated pregnancy timeline from the breeding date."
    lede="Work out the foaling date and pregnancy timeline from the breeding date."
    about="Mares foal about 340 days after breeding on average, but 320 to 370 days is normal, so the window is long. Mares bred early in the year and those carrying colts often go longer."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['date'], 'data' => collect(config('biology_data.gestation'))->only(['horse'])->all()]"
    :how-to="[
        ['name' => 'Breeding date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'How long are horses pregnant?', 'answer' => 'About 340 days (11 months), normally 320 to 370.'],
        ['question' => 'When should twins be checked?', 'answer' => 'At the first ultrasound, days 14 to 16, when one can still be pinched off.'],
        ['question' => 'What are signs foaling is near?', 'answer' => 'Udder filling, waxing of the teats and relaxed muscles near the tail head.'],
    ]"
>
    <x-calc.field name="date" label="Breeding date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Foaling date" />

    <x-calc.options :decimals="false" :examples="[
        'Bred 2 weeks ago' => ['date' => now()->subDays(14)->toDateString()],
        'Bred 30 days ago' => ['date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['date' => now()->subDays(333)->toDateString()],
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
            <li>due date = breeding date + 340 days</li>
            <li>normal range: day 320 to day 370</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
