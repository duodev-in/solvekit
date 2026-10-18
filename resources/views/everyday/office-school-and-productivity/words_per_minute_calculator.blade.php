<x-calc.page
    title="Words per Minute Calculator - SolveKit"
    description="Free words per minute calculator: typing speed in net and gross WPM, accuracy and characters per minute from a typing test."
    lede="Work out your typing speed in words per minute."
    about="Typing tests count a word as 5 keystrokes. Gross WPM = keystrokes ÷ 5 ÷ minutes; net WPM subtracts uncorrected errors per minute. Most people type about 30–50 WPM; professional typists often exceed 70."
    :calc="['engine' => 'ev-office', 'tool' => 'wpm', 'fields' => ['count', 'unit', 'minutes', 'seconds', 'errors']]"
    :how-to="[
        ['name' => 'Enter what you typed', 'text' => 'Keystrokes or words.'],
        ['name' => 'Enter time and errors', 'text' => 'Uncorrected errors.'],
    ]"
    :faqs="[
        ['question' => 'What is a good typing speed?', 'answer' => 'Above 40 WPM is good; above 70 is fast.'],
        ['question' => 'What is 1,250 keystrokes in 5 minutes with 6 errors?', 'answer' => '49 net WPM (50 gross).'],
        ['question' => 'Net vs gross WPM?', 'answer' => 'Net subtracts errors.'],
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

    <x-calc.result label="Net typing speed" />

    <x-calc.options :decimals="false" :examples="[
        '5-minute test' => ['count' => 1250, 'unit' => 'characters', 'minutes' => 5, 'seconds' => 0, 'errors' => 6],
        'Fast typist' => ['count' => 450, 'unit' => 'characters', 'minutes' => 1, 'seconds' => 0, 'errors' => 1],
        'Words, 3 minutes' => ['count' => 105, 'unit' => 'words', 'minutes' => 3, 'seconds' => 0, 'errors' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'accuracy' => ['label' => 'Accuracy'],
            'cpm' => ['label' => 'Characters a minute'],
            'level' => ['label' => 'Level'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>WPM = keystrokes ÷ 5 ÷ minutes − errors ÷ minutes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
