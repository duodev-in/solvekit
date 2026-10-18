<x-calc.page
    title="GWAM Calculator - SolveKit"
    description="Free GWAM calculator: gross words a minute, net words a minute and accuracy from a typing test."
    lede="Work out gross and net words a minute."
    about="Typing speed counts a word as 5 keystrokes, including spaces and punctuation. Gross words a minute (GWAM) = keystrokes ÷ 5 ÷ minutes. Net words a minute subtracts one word for each uncorrected error per minute: NWAM = GWAM − errors ÷ minutes."
    :calc="['engine' => 'ev-office', 'tool' => 'gwam', 'fields' => ['count', 'unit', 'minutes', 'seconds', 'errors']]"
    :how-to="[
        ['name' => 'Enter what you typed', 'text' => 'Keystrokes or words.'],
        ['name' => 'Enter time and errors', 'text' => 'Uncorrected errors.'],
    ]"
    :faqs="[
        ['question' => 'What is GWAM?', 'answer' => 'Gross words a minute: keystrokes ÷ 5 ÷ minutes.'],
        ['question' => 'What is 1,250 keystrokes in 5 minutes with 6 errors?', 'answer' => '50 GWAM and 48.8 net WPM.'],
        ['question' => 'Why 5 keystrokes a word?', 'answer' => 'It is the typing-test standard for an average word with its space.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="count" label="Typed" value="1250" min="0" step="1" />
        <x-calc.segmented name="unit" legend="Counted as" :options="['characters' => 'Keystrokes', 'words' => 'Words']" selected="characters" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="minutes" label="Minutes" value="5" min="0" step="1" />
        <x-calc.field name="seconds" label="Seconds" value="0" min="0" max="59" step="1" />
        <x-calc.field name="errors" label="Errors" value="6" min="0" step="1" />
    </div>

    <x-calc.result label="Gross words a minute" />

    <x-calc.options :examples="[
        '5-minute test' => ['count' => 1250, 'unit' => 'characters', 'minutes' => 5, 'seconds' => 0, 'errors' => 6],
        '1 minute, 45 words' => ['count' => 45, 'unit' => 'words', 'minutes' => 1, 'seconds' => 0, 'errors' => 2],
        '3 min 30 s' => ['count' => 900, 'unit' => 'characters', 'minutes' => 3, 'seconds' => 30, 'errors' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'net' => ['label' => 'Net WPM'],
            'accuracy' => ['label' => 'Accuracy'],
            'kph' => ['label' => 'Keystrokes an hour'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GWAM = keystrokes ÷ 5 ÷ minutes</li>
            <li>NWAM = GWAM − errors ÷ minutes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
