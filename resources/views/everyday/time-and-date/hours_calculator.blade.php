<x-calc.page
    title="Hours Calculator - SolveKit"
    description="Free hours calculator: hours and minutes between two times, overnight shifts, unpaid breaks, decimal hours and pay."
    lede="Work out the hours between two times."
    about="Hours = end time − start time; when the end is earlier than the start, the end is taken as the next day (an overnight shift). Unpaid break minutes are taken off. Decimal hours = hours + minutes ÷ 60, as used on timesheets: 7 h 45 min = 7.75 h."
    :calc="['engine' => 'ev-time', 'tool' => 'hours', 'fields' => ['start', 'end', 'break', 'rate']]"
    :how-to="[
        ['name' => 'Enter the start and end', 'text' => 'Overnight times are handled.'],
        ['name' => 'Take off breaks', 'text' => 'And add a rate to see pay.'],
    ]"
    :faqs="[
        ['question' => 'How many hours is 9 to 5:30 with a 30-minute lunch?', 'answer' => '8 hours.'],
        ['question' => 'How do I calculate hours overnight?', 'answer' => 'Count to midnight and add the hours after: 10 PM to 6 AM is 8 hours.'],
        ['question' => 'What is 45 minutes in decimal hours?', 'answer' => '0.75 hours.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start time" value="09:00" type="time" />
        <x-calc.field name="end" label="End time" value="17:30" type="time" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="break" label="Break" value="30" min="0" step="5" suffix="min" />
        <x-calc.field name="rate" label="Hourly rate (optional)" value="" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Hours" />

    <x-calc.options :decimals="false" :examples="[
        '9:00–17:30, 30 min break' => ['start' => '09:00', 'end' => '17:30', 'break' => 30, 'rate' => ''],
        'Night 22:00–06:00' => ['start' => '22:00', 'end' => '06:00', 'break' => 0, 'rate' => 25],
        '8:15–16:45 at $18' => ['start' => '08:15', 'end' => '16:45', 'break' => 45, 'rate' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hm' => ['label' => 'Hours and minutes'],
            'minutes' => ['label' => 'Minutes'],
            'span' => ['label' => 'Start to end'],
            'pay' => ['label' => 'Pay'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = end − start (+24 h if the end is earlier) − break</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
