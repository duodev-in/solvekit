<x-calc.page
    title="Podcast Calculator — Kill Your Dead Time - SolveKit"
    description="Free podcast calculator: how many podcast episodes you can get through in your dead time each year, and how long a back catalog takes."
    lede="See how many podcast episodes fit into your dead time."
    about="Episodes a year = minutes of dead time × days ÷ (episode length ÷ playback speed). Long-running shows can have hundreds of episodes; the back-catalog estimate shows how long catching up would take."
    :calc="['engine' => 'ev-fun', 'tool' => 'podcasts', 'fields' => ['minutes', 'days', 'episode', 'speed', 'backlog']]"
    :how-to="[
        ['name' => 'Enter your dead time', 'text' => 'Commute, chores, workouts.'],
        ['name' => 'Enter the show details', 'text' => 'Episode length, speed and back catalog.'],
    ]"
    :faqs="[
        ['question' => 'How many podcasts can I listen to a year?', 'answer' => '45 minutes a day on 330 days at 1.2× is about 356 episodes of 50 minutes.'],
        ['question' => 'How long to catch up on 400 episodes?', 'answer' => 'About 371 days at 45 minutes a day.'],
        ['question' => 'Does 1.2× save much?', 'answer' => 'About one episode in six.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="minutes" label="Dead time a day" value="45" min="1" step="5" suffix="min" />
        <x-calc.field name="days" label="Days a year" value="330" min="1" max="366" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="episode" label="Episode length" value="50" min="1" suffix="min" />
        <x-calc.field name="speed" label="Playback speed" value="1.2" min="0.5" max="3" step="0.05" suffix="×" />
        <x-calc.field name="backlog" label="Back catalog (optional)" value="400" min="0" step="1" suffix="episodes" />
    </div>

    <x-calc.result label="Podcast episodes in your dead time" />

    <x-calc.options :decimals="false" :examples="[
        '45 min, 1.2×' => ['minutes' => 45, 'days' => 330, 'episode' => 50, 'speed' => 1.2, 'backlog' => 400],
        'Daily news show' => ['minutes' => 20, 'days' => 260, 'episode' => 25, 'speed' => 1, 'backlog' => ''],
        'Long commute, 1.5×' => ['minutes' => 90, 'days' => 230, 'episode' => 75, 'speed' => 1.5, 'backlog' => 900],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'week' => ['label' => 'Per week'],
            'catalog' => ['label' => 'Back catalog'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>episodes = minutes × days ÷ (length ÷ speed)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
