<x-calc.page
    title="Pig Latin Translator - SolveKit"
    description="Free Pig Latin translator: translate English into Pig Latin, moving the first consonants to the end and adding ay."
    lede="Translate English into Pig Latin."
    about="Words starting with consonants move the first consonant cluster to the end and add ay (string → ingstray, quiet → ietquay); words starting with a vowel just add way (apple → appleway). Y counts as a consonant at the start of a word. Capital letters and punctuation are kept."
    :calc="['engine' => 'ev-fun', 'tool' => 'pig_latin', 'fields' => ['text', 'suffix']]"
    :how-to="[
        ['name' => 'Type or paste your text', 'text' => 'It converts as you type.'],
        ['name' => 'Copy the result', 'text' => 'With the Copy button.'],
    ]"
    :faqs="[
        ['question' => 'How do you say hello in Pig Latin?', 'answer' => 'Ellohay.'],
        ['question' => 'What about words starting with a vowel?', 'answer' => 'Add way: egg → eggway (some say yay or hay).'],
        ['question' => 'Is qu kept together?', 'answer' => 'Yes: quick → ickquay.'],
    ]"
>
    <x-calc.textarea name="text" label="Your text" value="Pig Latin is quite fun to speak" rows="3" />

    <x-calc.select name="suffix" label="Vowel words end in" :options="['way' => 'way (appleway)', 'yay' => 'yay (appleyay)', 'hay' => 'hay (applehay)']" selected="way" />

    <x-calc.result label="Converted text" />

    <x-calc.options :decimals="false" :examples="[
        'Sentence' => ['text' => 'Pig Latin is quite fun to speak', 'suffix' => 'way'],
        'Hello world' => ['text' => 'Hello, world!', 'suffix' => 'way'],
        'Yay style' => ['text' => 'Eat your apples every day', 'suffix' => 'yay'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>consonants + rest → rest + consonants + ay</li>
            <li>vowel word → word + way</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
