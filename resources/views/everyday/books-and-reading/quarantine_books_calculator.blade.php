<x-calc.page
    title="Quarantine Books Calculator - SolveKit"
    description="Free quarantine books calculator: how many books you can read in your free time from the hours a day you have, your reading pace and book length."
    lede="Find out how many books fit into your free time."
    about="Pages you can read = free hours a day × days × your pace in pages an hour; books = pages ÷ pages per book. It was made for lockdowns, but works for any holiday or stretch of free time. A typical novel is 300–400 pages, and a typical pace 30–50 pages an hour."
    :calc="['engine' => 'ev-books', 'tool' => 'free_time_books', 'fields' => ['hours', 'days', 'pace', 'pages']]"
    :how-to="[
        ['name' => 'Enter your free time', 'text' => 'Hours a day and number of days.'],
        ['name' => 'Enter your pace and book length', 'text' => 'Pages an hour and pages per book.'],
    ]"
    :faqs="[
        ['question' => 'How many books can I read in two weeks?', 'answer' => 'At 2 hours a day and 40 pages an hour, 3 books of 350 pages.'],
        ['question' => 'How long does a 350-page book take?', 'answer' => 'About 8 h 45 min at 40 pages an hour.'],
        ['question' => 'How fast do people read?', 'answer' => 'Adults average about 238 words a minute, roughly 45–50 pages an hour.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Free hours a day for reading" value="2" min="0.25" step="0.25" />
        <x-calc.field name="days" label="Days" value="14" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pace" label="Your pace" value="40" min="1" step="1" suffix="pages/hour" />
        <x-calc.field name="pages" label="Pages per book" value="350" min="1" step="10" />
    </div>

    <x-calc.result label="Books you can read" />

    <x-calc.options :examples="[
        'Two weeks, 2 h a day' => ['hours' => 2, 'days' => 14, 'pace' => 40, 'pages' => 350],
        'Summer holiday' => ['hours' => 3, 'days' => 30, 'pace' => 45, 'pages' => 400],
        'A month of evenings' => ['hours' => 1, 'days' => 30, 'pace' => 35, 'pages' => 300],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'exact' => ['label' => 'Exactly'],
            'perBook' => ['label' => 'Each book takes'],
            'week' => ['label' => 'Per week'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>books = hours a day × days × pages an hour ÷ pages per book</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
