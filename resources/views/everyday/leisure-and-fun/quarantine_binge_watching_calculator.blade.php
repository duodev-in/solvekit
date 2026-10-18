<x-calc.page
    title="Quarantine Binge Watching Calculator - SolveKit"
    description="Free binge watching calculator: how many days it takes to finish a series at your pace, skipping intros or watching faster, and your finish date."
    lede="Find out when you will finish a series."
    about="Total time = episodes × (episode length − skipped intro and credits) ÷ playback speed. Days = total ÷ hours a day. Made for lockdowns, useful for any binge."
    :calc="['engine' => 'ev-fun', 'tool' => 'binge', 'fields' => ['episodes', 'length', 'skip', 'speed', 'per_day', 'start']]"
    :how-to="[
        ['name' => 'Enter the series', 'text' => 'Episodes and their length.'],
        ['name' => 'Enter your pace', 'text' => 'Hours a day and any skipping.'],
    ]"
    :faqs="[
        ['question' => 'How long to binge 62 episodes of 47 minutes?', 'answer' => 'About 46.5 hours: 16 days at 3 hours a day (skipping 2 minutes each).'],
        ['question' => 'Does skipping intros help?', 'answer' => 'At 2 minutes an episode, it saves about 2 hours over 62 episodes.'],
        ['question' => 'Is binge watching bad for you?', 'answer' => 'Long sitting and late nights are the main concerns; take breaks.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="episodes" label="Episodes" value="62" min="1" step="1" />
        <x-calc.field name="length" label="Episode length" value="47" min="1" suffix="min" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="skip" label="Skipped intro and credits" value="2" min="0" suffix="min" />
        <x-calc.field name="speed" label="Playback speed" value="1" min="0.5" max="2" step="0.25" suffix="×" />
        <x-calc.field name="per_day" label="Hours a day" value="3" min="0.25" max="24" step="0.25" />
    </div>

    <x-calc.field name="start" label="Starting" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Days to finish" />

    <x-calc.options :decimals="false" :examples="[
        '62 episodes, 3 h a day' => ['episodes' => 62, 'length' => 47, 'skip' => 2, 'speed' => 1, 'per_day' => 3, 'start' => '2026-10-18'],
        'Sitcom, 1.25×' => ['episodes' => 236, 'length' => 22, 'skip' => 1, 'speed' => 1.25, 'per_day' => 2, 'start' => '2026-10-18'],
        'Weekend binge' => ['episodes' => 10, 'length' => 55, 'skip' => 0, 'speed' => 1, 'per_day' => 8, 'start' => '2026-10-24'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'finish' => ['label' => 'Finish date'],
            'total' => ['label' => 'Total'],
            'saved' => ['label' => 'Time saved'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = episodes × (length − skip) ÷ speed</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
