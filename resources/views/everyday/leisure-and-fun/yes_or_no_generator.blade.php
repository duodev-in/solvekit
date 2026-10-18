<x-calc.page
    title="Yes or No Generator - SolveKit"
    description="Free yes or no generator: a fair, random yes or no answer for any question, from your device's secure random number generator."
    lede="Get a random yes or no."
    about="Each toss draws a random number from your browser's cryptographically secure generator (Web Crypto): below one half gives Yes, otherwise No, so both are equally likely. The answer is kept for the same question and toss number; change the toss number to ask again. For fun only."
    :calc="['engine' => 'ev-fun', 'tool' => 'yes_no', 'fields' => ['question', 'toss']]"
    :how-to="[
        ['name' => 'Ask a question', 'text' => 'Or leave it blank.'],
        ['name' => 'Change the toss number', 'text' => 'For a new answer.'],
    ]"
    :faqs="[
        ['question' => 'Is it really random?', 'answer' => 'Yes, it uses the browser\'s secure random generator: a fair 50/50.'],
        ['question' => 'Why does the answer stay the same?', 'answer' => 'So editing the question does not keep changing it; change the toss number to re-roll.'],
        ['question' => 'Can I use it for decisions?', 'answer' => 'Only for fun or tie-breaks.'],
    ]"
>
    <x-calc.textarea name="question" label="Your question (optional)" value="Should I order pizza tonight?" rows="2" />

    <x-calc.field name="toss" label="Toss number" value="1" min="1" step="1" />

    <x-calc.result label="The answer is" />

    <x-calc.options :decimals="false" :examples="[
        'Pizza?' => ['question' => 'Should I order pizza tonight?', 'toss' => 1],
        'Second toss' => ['question' => 'Should I order pizza tonight?', 'toss' => 2],
        'No question' => ['question' => '', 'toss' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'again' => ['label' => 'Ask again'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>answer = Yes if random < 0.5, else No</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
