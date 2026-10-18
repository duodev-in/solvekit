<x-calc.page
    title="Reverse Time Calculator - SolveKit"
    description="Free reverse time calculator: when to start so you finish on time, working backwards from a deadline through each step."
    lede="Work backwards from when you need to be done to when you must start."
    about="Start = finish time − total time needed. Add the steps (cooking, travel, getting ready) with their minutes and the calculator lists when each starts, in order, finishing exactly at your deadline. Extra days, hours and minutes are added before the first step."
    :calc="['engine' => 'ev-time', 'tool' => 'reverse_time', 'fields' => ['end', 'steps', 'days', 'hours', 'minutes']]"
    :how-to="[
        ['name' => 'Enter the finish time', 'text' => 'When everything must be ready.'],
        ['name' => 'List the steps', 'text' => 'One per line: a name, a comma and its minutes.'],
    ]"
    :faqs="[
        ['question' => 'When should I start a 4¼-hour roast for 3 PM?', 'answer' => 'With 30 minutes prep, 30 resting and 15 to serve: at 9:30 AM.'],
        ['question' => 'Can it cross midnight?', 'answer' => 'Yes, the start date moves back as needed.'],
        ['question' => 'Can I just enter a duration?', 'answer' => 'Yes, leave the steps empty and use the extra hours and minutes.'],
    ]"
>
    <x-calc.field name="end" label="Finish by" value="2026-11-26T15:00" type="datetime-local" />

    <x-calc.textarea name="steps" label="Steps in order (name, minutes)" value="Prep the turkey, 30
Roast, 255
Rest, 30
Carve and serve, 15" rows="5" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="days" label="Extra days" value="0" min="0" step="1" />
        <x-calc.field name="hours" label="Extra hours" value="0" min="0" step="1" />
        <x-calc.field name="minutes" label="Extra minutes" value="0" min="0" step="1" />
    </div>

    <x-calc.result label="Start at" />

    <x-calc.options :decimals="false" :examples="[
        'Thanksgiving dinner at 3 PM' => ['end' => '2026-11-26T15:00', 'steps' => 'Prep the turkey, 30
Roast, 255
Rest, 30
Carve and serve, 15', 'days' => 0, 'hours' => 0, 'minutes' => 0],
        'Flight at 7 AM' => ['end' => '2026-12-20T07:00', 'steps' => 'Get ready, 45
Drive to airport, 50
Check-in and security, 120', 'days' => 0, 'hours' => 0, 'minutes' => 0],
        '36 hours before' => ['end' => '2026-10-31T18:00', 'steps' => '', 'days' => 1, 'hours' => 12, 'minutes' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'clock24' => ['label' => '24-hour clock'],
            'total' => ['label' => 'Total time'],
            'day' => ['label' => 'Day'],
        ]" />
        <x-calc.quick-ref heading="Schedule" name="schedule" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>start = finish − Σ step times − extra time</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
