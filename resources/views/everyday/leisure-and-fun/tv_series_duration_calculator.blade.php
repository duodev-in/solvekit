<x-calc.page
    title="TV Series Duration Calculator - SolveKit"
    description="Free TV series duration calculator: total watch time of a series from its seasons, episodes and episode length, and when you would finish."
    lede="Work out how long it takes to watch a whole series."
    about="Total time = seasons × episodes per season × episode length ÷ playback speed. For shows whose seasons differ in length, use the average episodes per season. Finish date = total ÷ hours a day from your start date."
    :calc="['engine' => 'ev-fun', 'tool' => 'series', 'fields' => ['seasons', 'per_season', 'length', 'speed', 'per_day', 'start']]"
    :how-to="[
        ['name' => 'Enter the series', 'text' => 'Seasons, episodes and length.'],
        ['name' => 'Enter your pace', 'text' => 'And start date.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 5-season show of 10 × 50 min?', 'answer' => '41 h 40 min: 21 days at 2 hours a day.'],
        ['question' => 'How do I handle uneven seasons?', 'answer' => 'Use the average episodes per season.'],
        ['question' => 'Does 1.25× speed help?', 'answer' => 'It saves a fifth of the time.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="seasons" label="Seasons" value="5" min="1" step="1" />
        <x-calc.field name="per_season" label="Episodes per season" value="10" min="1" step="1" />
        <x-calc.field name="length" label="Episode length" value="50" min="1" suffix="min" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="speed" label="Playback speed" value="1" min="0.5" max="2" step="0.25" suffix="×" />
        <x-calc.field name="per_day" label="Hours a day (optional)" value="2" min="0.25" max="24" step="0.25" />
        <x-calc.field name="start" label="Starting" value="{{ now()->toDateString() }}" type="date" />
    </div>

    <x-calc.result label="Total watch time" />

    <x-calc.options :decimals="false" :examples="[
        '5 × 10 × 50 min' => ['seasons' => 5, 'per_season' => 10, 'length' => 50, 'speed' => 1, 'per_day' => 2, 'start' => '2026-10-18'],
        'Long sitcom' => ['seasons' => 10, 'per_season' => 24, 'length' => 22, 'speed' => 1, 'per_day' => 1.5, 'start' => '2026-10-18'],
        'Prestige drama, 1.25×' => ['seasons' => 8, 'per_season' => 9, 'length' => 60, 'speed' => 1.25, 'per_day' => 3, 'start' => '2026-11-01'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'days' => ['label' => 'Nonstop'],
            'finish' => ['label' => 'Finish'],
            'episodes' => ['label' => 'Episodes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = seasons × episodes × length ÷ speed</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
