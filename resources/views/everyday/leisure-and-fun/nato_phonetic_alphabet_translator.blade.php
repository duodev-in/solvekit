<x-calc.page
    title="NATO Phonetic Alphabet Translator - SolveKit"
    description="Free NATO phonetic alphabet translator: spell any word, name or code with Alfa, Bravo, Charlie and the rest of the ICAO spelling alphabet."
    lede="Spell out words with the NATO phonetic alphabet."
    about="The ICAO/NATO spelling alphabet gives each letter a code word that is hard to mishear on a radio or phone: Alfa, Bravo, Charlie… Zulu. Alfa and Juliett are spelled that way so speakers of other languages say them correctly. Aviation also uses the spoken digits Tree, Fower, Fife and Niner."
    :calc="['engine' => 'ev-fun', 'tool' => 'nato', 'fields' => ['text', 'spoken']]"
    :how-to="[
        ['name' => 'Type a word or code', 'text' => 'Booking codes, names, postcodes.'],
        ['name' => 'Read it out', 'text' => 'Each letter as its code word.'],
    ]"
    :faqs="[
        ['question' => 'What is the NATO alphabet for SOS?', 'answer' => 'Sierra Oscar Sierra.'],
        ['question' => 'Why is it Alfa, not Alpha?', 'answer' => 'So speakers of all languages pronounce it the same.'],
        ['question' => 'Why Niner?', 'answer' => 'To avoid confusion with the German nein.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="SolveKit 2026" rows="2" />

    <x-calc.checkbox name="spoken" label="Use ICAO digit pronunciation (Tree, Fower, Fife, Niner)" :checked="false" />

    <x-calc.result label="NATO phonetic spelling" />

    <x-calc.options :decimals="false" :examples="[
        'Brand' => ['text' => 'SolveKit 2026', 'spoken' => false],
        'Booking code' => ['text' => 'QX7J9B', 'spoken' => true],
        'Name' => ['text' => 'Juliette Nguyen', 'spoken' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="Letters used" name="letters" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A Alfa · B Bravo · C Charlie · … · Z Zulu</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
