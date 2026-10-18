<x-calc.page
    title="Reading Challenge Calculator - SolveKit"
    description="Free reading challenge calculator: books a week and pages a day you need to reach a yearly reading goal, and whether you are on track."
    lede="See the pace you need to finish your reading challenge."
    about="Pace needed = books left ÷ days left. You are on track if the books you have read match an even pace through the challenge: goal × days gone ÷ total days. Add the average pages per book for a pages-a-day target."
    :calc="['engine' => 'ev-books', 'tool' => 'reading_challenge', 'fields' => ['goal', 'done', 'start', 'end', 'on', 'pages']]"
    :how-to="[
        ['name' => 'Enter your goal', 'text' => 'And how many books you have read.'],
        ['name' => 'Check the dates', 'text' => 'The challenge period and today.'],
    ]"
    :faqs="[
        ['question' => 'How many books a week is 52 a year?', 'answer' => 'One a week.'],
        ['question' => 'How many pages a day for 50 books?', 'answer' => 'At 320 pages a book, about 44 pages a day.'],
        ['question' => 'Am I behind?', 'answer' => 'Compare with an even pace: by mid-October, about 41 of 52 books.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="goal" label="Goal" value="52" min="1" step="1" suffix="books" />
        <x-calc.field name="done" label="Books read so far" value="38" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Challenge starts" value="2026-01-01" type="date" />
        <x-calc.field name="end" label="Challenge ends" value="2026-12-31" type="date" />
        <x-calc.field name="on" label="Today" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <x-calc.field name="pages" label="Average pages per book (optional)" value="320" min="1" step="10" />

    <x-calc.result label="Pace needed for the rest" />

    <x-calc.options :examples="[
        '52 books, 38 read' => ['goal' => 52, 'done' => 38, 'start' => '2026-01-01', 'end' => '2026-12-31', 'on' => '2026-10-18', 'pages' => 320],
        '24 books, 10 read' => ['goal' => 24, 'done' => 10, 'start' => '2026-01-01', 'end' => '2026-12-31', 'on' => '2026-07-01', 'pages' => 300],
        'Summer: 10 books' => ['goal' => 10, 'done' => 3, 'start' => '2026-06-01', 'end' => '2026-08-31', 'on' => '2026-07-15', 'pages' => 280],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pace' => ['label' => 'Books a day'],
            'pages' => ['label' => 'Pages a day'],
            'track' => ['label' => 'On track?'],
            'left' => ['label' => 'Days left'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pace = (goal − read) ÷ days left</li>
            <li>even pace = goal × days gone ÷ total days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
