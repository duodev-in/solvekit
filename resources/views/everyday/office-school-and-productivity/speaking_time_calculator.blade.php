<x-calc.page
    title="Speaking Time Calculator - SolveKit"
    description="Free speaking time calculator: how long a speech, presentation or script takes to say from its words and your speaking pace, and how many words fit a time limit."
    lede="Find out how long your speech will take."
    about="Speaking time = words ÷ speaking rate. Presentations are often delivered at about 120–150 words a minute, conversation at about 150–160 and fast speech above 170; 130 is a comfortable default. Pauses, slides and audience reactions add time."
    :calc="['engine' => 'ev-office', 'tool' => 'speaking', 'fields' => ['mode', 'text', 'words', 'pace', 'limit']]"
    :how-to="[
        ['name' => 'Paste the text', 'text' => 'Or enter the word count.'],
        ['name' => 'Set your pace', 'text' => 'Time yourself reading a paragraph.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 1,300-word speech?', 'answer' => 'About 10 minutes at 130 words a minute.'],
        ['question' => 'How many words for a 5-minute speech?', 'answer' => 'About 650 at 130 words a minute.'],
        ['question' => 'How fast do people speak?', 'answer' => 'Usually 120–160 words a minute.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Length from" :options="['text' => 'Paste the text', 'count' => 'Word count']" selected="text" />

    <div data-show-when="mode:text">
        <x-calc.textarea name="text" label="Text" value="The quick brown fox jumps over the lazy dog. It was a bright, cold day in April.

This second paragraph has a few more words, so the counts are easy to check." rows="5" />
    </div>

    <div data-show-when="mode:count" hidden>
        <x-calc.field name="words" label="Words" value="1300" min="1" step="10" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pace" label="Speaking rate" value="130" min="60" max="250" step="5" suffix="wpm" />
        <x-calc.field name="limit" label="Time limit (optional)" value="5" min="0" step="0.5" suffix="min" />
    </div>

    <x-calc.result label="Speaking time" />

    <x-calc.options :decimals="false" :examples="[
        '1,300-word speech' => ['mode' => 'count', 'text' => '', 'words' => 1300, 'pace' => 130, 'limit' => 10],
        'Wedding toast' => ['mode' => 'count', 'text' => '', 'words' => 500, 'pace' => 120, 'limit' => 4],
        'Pasted text' => ['mode' => 'text', 'text' => 'The quick brown fox jumps over the lazy dog. It was a bright, cold day in April.

This second paragraph has a few more words, so the counts are easy to check.', 'words' => '', 'pace' => 150, 'limit' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'slow' => ['label' => 'Slowly'],
            'fast' => ['label' => 'Briskly'],
            'limit' => ['label' => 'For your limit'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>minutes = words ÷ words per minute</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
