<x-calc.page
    title="Reading Time Calculator - SolveKit"
    description="Free reading time calculator: how long a book, article or speech takes to read from its pages or words and your reading speed."
    lede="Find out how long a book or text takes to read."
    about="Reading time = words ÷ words per minute. With pages, words = pages × words per page (about 250–300 in a typical paperback). The default speed of 238 words a minute is the adult average for silent reading (Brysbaert 2019); measure your own with the Reading Speed calculator."
    :calc="['engine' => 'ev-books', 'tool' => 'reading_time', 'fields' => ['mode', 'pages', 'per_page', 'words', 'wpm', 'daily']]"
    :how-to="[
        ['name' => 'Enter the length', 'text' => 'Pages or words.'],
        ['name' => 'Enter your speed', 'text' => 'And minutes a day for a finish date.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 300-page book take to read?', 'answer' => 'About 6 h 18 min at 238 words a minute and 300 words a page.'],
        ['question' => 'How many words are on a page?', 'answer' => 'About 250–300 in a paperback novel.'],
        ['question' => 'How long does a 90,000-word novel take?', 'answer' => 'About 6 h 18 min at average speed.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Length in" :options="['pages' => 'Pages', 'words' => 'Words']" selected="pages" />

    <div data-show-when="mode:pages">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="pages" label="Pages" value="320" min="1" step="1" />
            <x-calc.field name="per_page" label="Words per page" value="300" min="50" step="10" />
        </div>
    </div>

    <div data-show-when="mode:words" hidden>
        <x-calc.field name="words" label="Words" value="90000" min="1" step="100" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="wpm" label="Reading speed" value="238" min="50" step="1" suffix="words/min" />
        <x-calc.field name="daily" label="Minutes a day (optional)" value="30" min="0" step="5" />
    </div>

    <x-calc.result label="Reading time" />

    <x-calc.options :examples="[
        '320-page novel' => ['mode' => 'pages', 'pages' => 320, 'per_page' => 300, 'wpm' => 238, 'daily' => 30],
        '90,000 words' => ['mode' => 'words', 'words' => 90000, 'wpm' => 238, 'daily' => 45],
        'Long article' => ['mode' => 'words', 'words' => 4500, 'wpm' => 260, 'daily' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'minutes' => ['label' => 'Minutes'],
            'days' => ['label' => 'Finish'],
            'aloud' => ['label' => 'Read aloud'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = words ÷ words per minute</li>
            <li>words = pages × words per page</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
