<x-calc.page
    title="Pomodoro Technique Calculator - SolveKit"
    description="Free Pomodoro technique calculator: a schedule of focus sessions and breaks with the finish time and total focus hours."
    lede="Plan a Pomodoro work session."
    about="The Pomodoro Technique (Francesco Cirillo) alternates 25 minutes of focus with 5-minute breaks, and a longer 15–30 minute break after every 4 pomodoros. Change the lengths to suit you; the schedule shows when each session starts and ends."
    :calc="['engine' => 'ev-office', 'tool' => 'pomodoro', 'fields' => ['start', 'sessions', 'work', 'short_break', 'long_break', 'every']]"
    :how-to="[
        ['name' => 'Enter the start and sessions', 'text' => 'How many pomodoros.'],
        ['name' => 'Adjust lengths', 'text' => '25/5 with a long break every 4 is classic.'],
    ]"
    :faqs="[
        ['question' => 'How long are 8 pomodoros?', 'answer' => '4 h 10 min with six 5-minute breaks and one 20-minute long break: 3 h 20 min of focus.'],
        ['question' => 'How long is a long break?', 'answer' => '15–30 minutes after every 4 pomodoros.'],
        ['question' => 'Can I change the lengths?', 'answer' => 'Yes, many people use 50/10.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start time" value="09:00" type="time" />
        <x-calc.field name="sessions" label="Focus sessions" value="8" min="1" max="24" step="1" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="work" label="Focus" value="25" min="5" step="5" suffix="min" />
        <x-calc.field name="short_break" label="Short break" value="5" min="0" step="1" suffix="min" />
        <x-calc.field name="long_break" label="Long break" value="20" min="0" step="5" suffix="min" />
        <x-calc.field name="every" label="Long break every" value="4" min="1" step="1" />
    </div>

    <x-calc.result label="Finish time" />

    <x-calc.options :decimals="false" :examples="[
        'Classic 8 sessions' => ['start' => '09:00', 'sessions' => 8, 'work' => 25, 'short_break' => 5, 'long_break' => 20, 'every' => 4],
        '50/10 deep work' => ['start' => '08:30', 'sessions' => 4, 'work' => 50, 'short_break' => 10, 'long_break' => 30, 'every' => 2],
        'Study evening' => ['start' => '19:00', 'sessions' => 6, 'work' => 30, 'short_break' => 5, 'long_break' => 15, 'every' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'focus' => ['label' => 'Focus time'],
            'total' => ['label' => 'Total time'],
        ]" />
        <x-calc.quick-ref heading="Schedule" name="schedule" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>end = start + sessions × focus + breaks</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
