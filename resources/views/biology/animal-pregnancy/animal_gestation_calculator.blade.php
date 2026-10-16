<x-calc.page
    title="Animal Gestation Calculator - SolveKit"
    description="Free animal gestation calculator: due date, normal whelping window and a dated pregnancy timeline from the breeding date."
    lede="Work out the whelping date and pregnancy timeline from the breeding date."
    about="Pick a species and the breeding date to get the due date, normal birth window and a dated timeline. Lengths are typical values; breed, litter size and the individual animal all shift them."
    :calc="['engine' => 'gestation', 'tool' => 'gestation', 'fields' => ['species', 'date'], 'data' => collect(config('biology_data.gestation'))->only(['dog', 'cat', 'cow', 'horse', 'goat', 'sheep', 'pig', 'llama', 'alpaca', 'rabbit', 'guinea_pig', 'hamster', 'ferret'])->all()]"
    :how-to="[
        ['name' => 'Breeding date', 'text' => 'The day of mating, or the first of several matings.'],
        ['name' => 'Read the due date', 'text' => 'With the earliest and latest normal dates.'],
        ['name' => 'Follow the timeline', 'text' => 'The next milestone is highlighted.'],
    ]"
    :faqs="[
        ['question' => 'Which animal has the longest pregnancy here?', 'answer' => 'The llama, at about 350 days, followed by the horse.'],
        ['question' => 'Which is shortest?', 'answer' => 'The Syrian hamster, at about 16 days.'],
        ['question' => 'Why is there a range?', 'answer' => 'Litter size, breed and the exact day of conception all vary.'],
    ]"
>
    <x-calc.select name="species" label="Species" :options="collect(config('biology_data.gestation'))->only(['dog', 'cat', 'cow', 'horse', 'goat', 'sheep', 'pig', 'llama', 'alpaca', 'rabbit', 'guinea_pig', 'hamster', 'ferret'])->map(fn ($item) => $item['name'])->all()" selected="dog" />

    <x-calc.field name="date" label="Breeding date" value="{{ now()->subDays(30)->toDateString() }}" type="date" />

    <x-calc.result label="Whelping date" />

    <x-calc.options :decimals="false" :examples="[
        'Dog, bred 30 days ago' => ['species' => 'dog', 'date' => now()->subDays(30)->toDateString()],
        'Cat, bred 30 days ago' => ['species' => 'cat', 'date' => now()->subDays(30)->toDateString()],
        'Cow, bred 30 days ago' => ['species' => 'cow', 'date' => now()->subDays(30)->toDateString()],
        'Due in about a week' => ['species' => 'dog', 'date' => now()->subDays(56)->toDateString()],
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
            <li>due date = breeding date + 63 days</li>
            <li>normal range: day 58 to day 68</li>
            <li>milestones are typical days; individuals vary</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
