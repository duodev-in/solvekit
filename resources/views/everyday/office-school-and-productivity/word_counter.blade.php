<x-calc.page
    title="Word Counter - SolveKit"
    description="Free word counter: count words, characters with and without spaces, sentences and paragraphs, with reading and speaking time and the most used words."
    lede="Count the words and characters in any text."
    about="Words are counted with the browser's Unicode word segmentation, so contractions such as don't count once and punctuation is ignored; characters count what you see, so an emoji is one. Reading time uses 238 words a minute (the adult silent reading average) and speaking time 130."
    :calc="['engine' => 'ev-office', 'tool' => 'word_count', 'fields' => ['text']]"
    :how-to="[
        ['name' => 'Paste or type your text', 'text' => 'The counts update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many words is a page?', 'answer' => 'About 500 single-spaced or 250 double-spaced.'],
        ['question' => 'Are numbers counted as words?', 'answer' => 'Yes, 5 or 2026 count as one word each.'],
        ['question' => 'Does it count characters with spaces?', 'answer' => 'Both, with and without spaces.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="The quick brown fox jumps over the lazy dog. It was a bright, cold day in April.

This second paragraph has a few more words, so the counts are easy to check." rows="8" />

    <x-calc.result label="Word count" />

    <x-calc.options :decimals="false" :examples="[
        'Sample' => ['text' => 'The quick brown fox jumps over the lazy dog. It was a bright, cold day in April.

This second paragraph has a few more words, so the counts are easy to check.'],
        'Tweet length' => ['text' => 'Just shipped 210 everyday calculators — dates, travel, home, work and fun. Each one shows its formula and sources! 🚀'],
        'One sentence' => ['text' => 'Don\'t stop: it\'s only five o\'clock.'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sentences' => ['label' => 'Sentences'],
            'paragraphs' => ['label' => 'Paragraphs'],
            'reading' => ['label' => 'Reading time'],
            'speaking' => ['label' => 'Speaking time'],
            'average' => ['label' => 'Averages'],
        ]" />
        <x-calc.quick-ref heading="Most used words (4+ letters)" name="top" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>words: Unicode word boundaries; characters: grapheme clusters</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
