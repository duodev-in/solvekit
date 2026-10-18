<x-calc.page
    title="8-Hour Shift Calculator - SolveKit"
    description="Free 8-hour shift calculator: when a shift ends, paid hours after breaks, weekly hours, and the three 8-hour shifts that cover a day."
    lede="Work out when an 8-hour shift ends and how many hours you are paid."
    about="The shift ends its length after the start. Paid hours are the shift length minus any unpaid break. Three 8-hour shifts cover 24 hours (often 7:00–15:00, 15:00–23:00 and 23:00–7:00); a 30-minute unpaid lunch leaves 7.5 paid hours. Enter another length for 10- or 12-hour shifts."
    :calc="['engine' => 'ev-time', 'tool' => 'shift', 'fields' => ['start', 'length', 'break', 'days', 'paid_break']]"
    :how-to="[
        ['name' => 'Enter the start time and length', 'text' => '8 hours for a standard shift.'],
        ['name' => 'Enter the break', 'text' => 'Tick if it is paid.'],
    ]"
    :faqs="[
        ['question' => 'How many hours is an 8-hour shift with lunch?', 'answer' => 'With an unpaid 30-minute lunch, 7.5 paid hours; a paid break keeps 8.'],
        ['question' => 'What are the three 8-hour shifts?', 'answer' => 'Commonly 7 AM–3 PM, 3 PM–11 PM and 11 PM–7 AM.'],
        ['question' => 'How many hours a week is five 8-hour shifts?', 'answer' => '40 hours, or 37.5 with an unpaid half-hour break each day.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Shift starts" value="07:00" type="time" />
        <x-calc.field name="length" label="Shift length" value="8" min="0.25" max="24" step="0.25" suffix="hours" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="break" label="Break" value="30" min="0" step="5" suffix="min" />
        <x-calc.field name="days" label="Shifts a week" value="5" min="1" max="7" step="1" />
    </div>

    <x-calc.checkbox name="paid_break" label="The break is paid" :checked="false" />

    <x-calc.result label="Shift ends" />

    <x-calc.options :decimals="false" :examples="[
        '7 AM, 30 min unpaid' => ['start' => '07:00', 'length' => 8, 'break' => 30, 'days' => 5, 'paid_break' => false],
        'Night shift 11 PM' => ['start' => '23:00', 'length' => 8, 'break' => 30, 'days' => 5, 'paid_break' => true],
        '12-hour shift, 4 days' => ['start' => '06:00', 'length' => 12, 'break' => 60, 'days' => 4, 'paid_break' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'paid' => ['label' => 'Paid hours per shift'],
            'week' => ['label' => 'Paid hours a week'],
            'clock24' => ['label' => '24-hour clock'],
            'cover' => ['label' => 'Shifts in a day'],
        ]" />
        <x-calc.quick-ref heading="Shifts covering the day" name="rotation" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>end = start + length</li>
            <li>paid = length − unpaid break</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
