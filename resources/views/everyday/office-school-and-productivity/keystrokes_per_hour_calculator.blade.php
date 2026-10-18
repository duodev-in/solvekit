<x-calc.page
    title="Keystrokes per Hour Calculator - SolveKit"
    description="Free keystrokes per hour calculator: KPH from keystrokes and time or from words a minute, for data entry tests."
    lede="Work out your keystrokes per hour."
    about="Keystrokes per hour (KPH) = keystrokes ÷ hours. From typing speed, KPH = WPM × 5 × 60, because a word is counted as 5 keystrokes. Data entry tests often count only correct keystrokes, sometimes on the numeric keypad; check the test's rules."
    :calc="['engine' => 'ev-office', 'tool' => 'kph', 'fields' => ['mode', 'keystrokes', 'minutes', 'seconds', 'wpm']]"
    :how-to="[
        ['name' => 'Choose the input', 'text' => 'Keystrokes and time, or WPM.'],
        ['name' => 'Enter the values', 'text' => 'From your test.'],
    ]"
    :faqs="[
        ['question' => 'What is 40 WPM in KPH?', 'answer' => '12,000 keystrokes an hour.'],
        ['question' => 'What KPH do data entry jobs want?', 'answer' => 'Often 8,000–10,000 KPH.'],
        ['question' => 'What is 1,500 keystrokes in 10 minutes?', 'answer' => '9,000 KPH.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['keystrokes' => 'Keystrokes and time', 'wpm' => 'Words a minute']" selected="keystrokes" />

    <div data-show-when="mode:keystrokes">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="keystrokes" label="Keystrokes" value="1500" min="0" step="1" />
            <x-calc.field name="minutes" label="Minutes" value="10" min="0" step="1" />
            <x-calc.field name="seconds" label="Seconds" value="0" min="0" max="59" step="1" />
        </div>
    </div>

    <div data-show-when="mode:wpm" hidden>
        <x-calc.field name="wpm" label="Words a minute" value="40" min="0" step="1" />
    </div>

    <x-calc.result label="Keystrokes per hour (KPH)" />

    <x-calc.options :examples="[
        '1,500 in 10 min' => ['mode' => 'keystrokes', 'keystrokes' => 1500, 'minutes' => 10, 'seconds' => 0, 'wpm' => ''],
        '40 WPM' => ['mode' => 'wpm', 'keystrokes' => '', 'minutes' => '', 'seconds' => '', 'wpm' => 40],
        '10-key test' => ['mode' => 'keystrokes', 'keystrokes' => 2100, 'minutes' => 12, 'seconds' => 30, 'wpm' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kpm' => ['label' => 'Per minute'],
            'wpm' => ['label' => 'Words a minute'],
            'note' => ['label' => 'Jobs'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>KPH = keystrokes ÷ hours = WPM × 300</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
