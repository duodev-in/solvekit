<x-calc.page
    title="Olga Tokarczuk Books Calculator - SolveKit"
    description="Free Olga Tokarczuk books calculator: how long it takes to read Flights, Drive Your Plow Over the Bones of the Dead, The Books of Jacob and her other English translations."
    lede="Work out how long it takes to read Olga Tokarczuk's books in English."
    about="Olga Tokarczuk won the 2018 Nobel Prize in Literature (awarded in 2019) and the 2018 International Booker Prize for Flights. Page counts are for the English editions listed (Open Library records); time = pages ÷ your pace. A typical novel pace is 30–50 pages an hour. Choose another book or edition to enter its pages yourself."
    :calc="['engine' => 'ev-books', 'tool' => 'tokarczuk', 'fields' => ['book', 'custom_pages', 'pace', 'minutes'], 'data' => ['tokarczuk' => config('everyday_data.tokarczuk')]]"
    :how-to="[
        ['name' => 'Choose a book', 'text' => 'Or all five.'],
        ['name' => 'Set your pace', 'text' => 'Pages an hour, and minutes a day.'],
    ]"
    :faqs="[
        ['question' => 'How long is The Books of Jacob?', 'answer' => '992 pages in the Riverhead edition: about 25 hours at 40 pages an hour.'],
        ['question' => 'What is her shortest book in English?', 'answer' => 'Drive Your Plow Over the Bones of the Dead, 274 pages in the Riverhead edition.'],
        ['question' => 'Why did she win the Nobel Prize?', 'answer' => 'For “a narrative imagination that with encyclopedic passion represents the crossing of boundaries as a form of life”.'],
    ]"
>
    <x-calc.select name="book" label="Book" :options="['all' => 'All five books'] + collect(config('everyday_data.tokarczuk'))->mapWithKeys(fn ($b) => [$b[0] => $b[1].' ('.$b[3].' pages)'])->all() + ['custom' => 'Another book or edition']" selected="all" />

    <div data-show-when="book:custom" hidden>
        <x-calc.field name="custom_pages" label="Pages" value="320" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pace" label="Your pace" value="40" min="1" step="1" suffix="pages/hour" />
        <x-calc.field name="minutes" label="Minutes a day (optional)" value="45" min="0" step="5" />
    </div>

    <x-calc.result label="Time to read" />

    <x-calc.options :decimals="false" :examples="[
        'All five books' => ['book' => 'all', 'pace' => 40, 'minutes' => 45],
        'The Books of Jacob' => ['book' => 'books_of_jacob', 'pace' => 40, 'minutes' => 60],
        'Flights, slowly' => ['book' => 'flights', 'pace' => 30, 'minutes' => 30],
        'The Empusium (your edition)' => ['book' => 'custom', 'custom_pages' => 320, 'pace' => 40, 'minutes' => 45],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pages' => ['label' => 'Pages'],
            'hours' => ['label' => 'Hours'],
            'days' => ['label' => 'Finish'],
        ]" />
        <x-calc.quick-ref heading="Books" name="books" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = pages ÷ pages per hour</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
