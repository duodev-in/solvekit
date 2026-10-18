<x-calc.page
    title="Reverse Text Generator - SolveKit"
    description="Free reverse text generator: write text backwards, reverse the order of words, or reverse each word, keeping emoji and accented letters intact."
    lede="Write text backwards."
    about="Text is reversed by user-visible character (grapheme), so emoji, flags and accented letters stay whole. You can also reverse only the word order or each word in place. It also tells you whether the text is a palindrome."
    :calc="['engine' => 'ev-office', 'tool' => 'reverse', 'fields' => ['text', 'mode']]"
    :how-to="[
        ['name' => 'Type or paste text', 'text' => 'Any language.'],
        ['name' => 'Pick how to reverse it', 'text' => 'Characters, words or each word.'],
    ]"
    :faqs="[
        ['question' => 'How do I write text backwards?', 'answer' => 'Paste it above and copy the result.'],
        ['question' => 'Is Never odd or even a palindrome?', 'answer' => 'Yes, ignoring spaces and case.'],
        ['question' => 'Does it break emoji?', 'answer' => 'No, emoji stay whole.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="Never odd or even" rows="4" />

    <x-calc.segmented name="mode" legend="Reverse" :options="['characters' => 'All characters', 'words' => 'Word order', 'each_word' => 'Each word']" selected="characters" />

    <x-calc.result label="Reversed text" />

    <x-calc.options :decimals="false" :examples="[
        'Palindrome' => ['text' => 'Never odd or even', 'mode' => 'characters'],
        'Word order' => ['text' => 'one two three four', 'mode' => 'words'],
        'Each word' => ['text' => 'Hello world 👋', 'mode' => 'each_word'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'palindrome' => ['label' => 'Palindrome?'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>reverse the list of graphemes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
