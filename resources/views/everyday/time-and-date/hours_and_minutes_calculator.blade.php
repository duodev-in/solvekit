<x-calc.page
    title="Hours and Minutes Calculator - SolveKit"
    description="Free hours and minutes calculator: add and subtract a list of times in hours and minutes, with the total in h:mm, decimal hours and minutes."
    lede="Add up hours and minutes, or take some away."
    about="Each line is a time in hours:minutes (1:30), with h and m (1h 30m), or decimal hours (1.5); start a line with − to subtract it. Minutes carry over every 60: 0:45 + 0:30 = 1:15. Totals are shown in hours:minutes, decimal hours and minutes."
    :calc="['engine' => 'ev-time', 'tool' => 'hours_minutes', 'fields' => ['times']]"
    :how-to="[
        ['name' => 'Enter each time on its own line', 'text' => '1:30, 1h 30m or 1.5.'],
        ['name' => 'Subtract with a minus', 'text' => 'For example −0:30.'],
    ]"
    :faqs="[
        ['question' => 'How do I add hours and minutes?', 'answer' => 'Add the hours and the minutes separately, then turn each 60 minutes into an hour: 7:45 + 8:15 = 16:00.'],
        ['question' => 'How do I subtract time?', 'answer' => 'Put a minus in front: 8:00 − 0:45 = 7:15.'],
        ['question' => 'What is 2.5 hours?', 'answer' => '2 hours 30 minutes.'],
    ]"
>
    <x-calc.textarea name="times" label="Times (one per line, − to subtract)" value="7:45
8:15
6:30
-0:45
2h 20m" rows="7" />

    <x-calc.result label="Total" />

    <x-calc.options :decimals="false" :examples="[
        'Timesheet' => ['times' => '7:45
8:15
6:30
-0:45
2h 20m'],
        'Week of shifts' => ['times' => '8:30
8:30
9:15
7:45
8:00'],
        'Decimal and minutes' => ['times' => '1.5
90m
-0:20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'Decimal hours'],
            'minutes' => ['label' => 'Minutes'],
            'days' => ['label' => 'Days and hours'],
        ]" />
        <x-calc.quick-ref heading="Your entries" name="entries" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>total = Σ (hours × 60 + minutes), shown as h:mm</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
