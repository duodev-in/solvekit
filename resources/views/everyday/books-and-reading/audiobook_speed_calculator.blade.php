<x-calc.page
    title="Audiobook Speed Calculator - SolveKit"
    description="Free audiobook speed calculator: how long an audiobook takes at 1.25×, 1.5×, 2× or any playback speed, the time saved and when you will finish."
    lede="Work out how long an audiobook takes at a faster playback speed."
    about="Listening time = length ÷ playback speed: a 10-hour book at 1.5× takes 6 h 40 min. Narrators read at about 150–160 words a minute, so 2× is roughly 310 words a minute, faster than most people read silently. Add the minutes you listen each day for a finish date."
    :calc="['engine' => 'ev-books', 'tool' => 'audiobook_speed', 'fields' => ['hours', 'minutes', 'speed', 'daily']]"
    :how-to="[
        ['name' => 'Enter the book length', 'text' => 'From the audiobook app or store.'],
        ['name' => 'Pick a speed', 'text' => 'And your daily listening time.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 10-hour audiobook at 1.5×?', 'answer' => '6 hours 40 minutes.'],
        ['question' => 'How much time does 2× save?', 'answer' => 'Half the length: a 12-hour book takes 6 hours.'],
        ['question' => 'Is 2× too fast?', 'answer' => 'Many listeners manage 1.5× to 2× for familiar narrators; slow down for dense books.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Length: hours" value="11" min="0" step="1" />
        <x-calc.field name="minutes" label="Minutes" value="45" min="0" max="59" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="speed" label="Playback speed" value="1.5" min="0.5" max="4" step="0.05" suffix="×" />
        <x-calc.field name="daily" label="Minutes a day (optional)" value="45" min="0" step="5" />
    </div>

    <x-calc.result label="Listening time" />

    <x-calc.options :examples="[
        '11 h 45 min at 1.5×' => ['hours' => 11, 'minutes' => 45, 'speed' => 1.5, 'daily' => 45],
        '10 h at 2×' => ['hours' => 10, 'minutes' => 0, 'speed' => 2, 'daily' => 30],
        '20 h at 1.25×' => ['hours' => 20, 'minutes' => 30, 'speed' => 1.25, 'daily' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'saved' => ['label' => 'Time saved'],
            'days' => ['label' => 'Finish'],
            'words' => ['label' => 'Speech rate'],
        ]" />
        <x-calc.quick-ref heading="At each speed" name="speeds" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = length ÷ speed</li>
            <li>saved = length − time</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
