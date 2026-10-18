<x-calc.page
    title="Audiobooks Calculator – Reclaim the Dead Time - SolveKit"
    description="Free audiobooks calculator: how many audiobooks you can finish a year by listening in your dead time, such as commuting, chores and exercise."
    lede="See how many books your commute and chores could add up to."
    about="Books a year = minutes of dead time a day × days ÷ (book length ÷ playback speed). The average audiobook runs about 10–12 hours. Commutes, cleaning, cooking, walks and workouts add up fast."
    :calc="['engine' => 'ev-fun', 'tool' => 'dead_time_books', 'fields' => ['minutes', 'days', 'length', 'speed']]"
    :how-to="[
        ['name' => 'Add up your dead time', 'text' => 'Commute, chores, exercise.'],
        ['name' => 'Set book length and speed', 'text' => 'About 11 hours is typical.'],
    ]"
    :faqs="[
        ['question' => 'How many audiobooks can I listen to a year?', 'answer' => 'An hour a day on 300 days at 1.25× is about 34 books of 11 hours.'],
        ['question' => 'How long is an average audiobook?', 'answer' => 'About 10–12 hours.'],
        ['question' => 'Does speed matter?', 'answer' => 'At 1.5× you finish a third more books.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="minutes" label="Dead time a day" value="60" min="1" step="5" suffix="min" />
        <x-calc.field name="days" label="Days a year" value="300" min="1" max="366" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Typical book length" value="11" min="1" step="0.5" suffix="hours" />
        <x-calc.field name="speed" label="Playback speed" value="1.25" min="0.5" max="3" step="0.05" suffix="×" />
    </div>

    <x-calc.result label="Books in your dead time" />

    <x-calc.options :decimals="false" :examples="[
        '1 h a day, 1.25×' => ['minutes' => 60, 'days' => 300, 'length' => 11, 'speed' => 1.25],
        'Long commute' => ['minutes' => 100, 'days' => 230, 'length' => 12, 'speed' => 1.5],
        'Chores only' => ['minutes' => 25, 'days' => 365, 'length' => 10, 'speed' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hours' => ['label' => 'Hours a year'],
            'month' => ['label' => 'Per month'],
            'book' => ['label' => 'Pace'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>books = minutes × days ÷ 60 ÷ (length ÷ speed)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
