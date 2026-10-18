<x-calc.page
    title="Reading Speed Calculator - SolveKit"
    description="Free reading speed calculator: your words per minute from a timed reading, pages per hour, and how you compare with the adult average of 238 words a minute."
    lede="Measure your reading speed in words per minute."
    about="Reading speed = words read ÷ minutes. Time yourself reading a passage at a normal pace and count its words (or use a word counter). A 2019 review of 190 studies (Brysbaert, Journal of Memory and Language) found adults read silently at about 238 words a minute for non-fiction and 260 for fiction. Pages per hour assume about 300 words a page; change it for your book."
    :calc="['engine' => 'ev-books', 'tool' => 'reading_speed', 'fields' => ['words', 'minutes', 'seconds', 'per_page']]"
    :how-to="[
        ['name' => 'Time a reading', 'text' => 'Read normally, not skimming.'],
        ['name' => 'Enter words and time', 'text' => 'Count the words in the passage.'],
    ]"
    :faqs="[
        ['question' => 'What is the average reading speed?', 'answer' => 'About 238 words a minute for non-fiction and 260 for fiction (Brysbaert 2019).'],
        ['question' => 'What is 1,200 words in 5 minutes?', 'answer' => '240 words a minute, close to average.'],
        ['question' => 'Can speed reading triple my speed?', 'answer' => 'Studies find big speed gains usually cost comprehension.'],
    ]"
>
    <x-calc.field name="words" label="Words read" value="1200" min="1" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="minutes" label="Minutes" value="5" min="0" step="1" />
        <x-calc.field name="seconds" label="Seconds" value="0" min="0" max="59" step="1" />
    </div>

    <x-calc.field name="per_page" label="Words per page" value="300" min="50" step="10" />

    <x-calc.result label="Reading speed" />

    <x-calc.options :examples="[
        '1,200 words in 5 min' => ['words' => 1200, 'minutes' => 5, 'seconds' => 0, 'per_page' => 300],
        '800 words in 2 min 30 s' => ['words' => 800, 'minutes' => 2, 'seconds' => 30, 'per_page' => 300],
        'Slow, careful read' => ['words' => 600, 'minutes' => 4, 'seconds' => 0, 'per_page' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'pages' => ['label' => 'Pages an hour'],
            'average' => ['label' => 'Against the average'],
            'book' => ['label' => 'A 90,000-word novel'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>WPM = words ÷ minutes</li>
            <li>pages an hour = WPM × 60 ÷ words per page</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
