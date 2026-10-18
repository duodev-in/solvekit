<x-calc.page
    title="Time to Decimal Calculator - SolveKit"
    description="Free time to decimal calculator: hours, minutes and seconds to decimal hours for timesheets and payroll, and decimal hours back to h:mm:ss."
    lede="Convert hours and minutes to decimal hours, or back."
    about="Decimal hours = hours + minutes ÷ 60 + seconds ÷ 3,600, so 7 h 45 min is 7.75 h. Going back, the decimal part × 60 gives minutes: 8.2 h is 8 h 12 min. Payroll systems often round to the nearest quarter hour; this shows the exact value."
    :calc="['engine' => 'ev-time', 'tool' => 'time_decimal', 'fields' => ['mode', 'hours', 'minutes', 'seconds', 'decimal']]"
    :how-to="[
        ['name' => 'Choose the direction', 'text' => 'To decimal or back.'],
        ['name' => 'Enter the time', 'text' => 'Or the decimal hours.'],
    ]"
    :faqs="[
        ['question' => 'What is 7 hours 45 minutes in decimal?', 'answer' => '7.75 hours.'],
        ['question' => 'What is 8.2 hours in hours and minutes?', 'answer' => '8 hours 12 minutes.'],
        ['question' => 'What is 20 minutes in decimal hours?', 'answer' => '0.333… hours.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Convert" :options="['time' => 'Time → decimal', 'decimal' => 'Decimal → time']" selected="time" />

    <div data-show-when="mode:time">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="hours" label="Hours" value="7" min="0" step="1" />
            <x-calc.field name="minutes" label="Minutes" value="45" min="0" step="1" />
            <x-calc.field name="seconds" label="Seconds" value="0" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:decimal" hidden>
        <x-calc.field name="decimal" label="Decimal hours" value="8.2" min="0" step="any" suffix="h" />
    </div>

    <x-calc.result label="Decimal hours" />

    <x-calc.options :examples="[
        '7:45' => ['mode' => 'time', 'hours' => 7, 'minutes' => 45, 'seconds' => 0],
        '1:20:30' => ['mode' => 'time', 'hours' => 1, 'minutes' => 20, 'seconds' => 30],
        '8.2 h' => ['mode' => 'decimal', 'decimal' => 8.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'minutes' => ['label' => 'Minutes'],
            'seconds' => ['label' => 'Seconds'],
            'hms' => ['label' => 'h:mm:ss'],
            'days' => ['label' => 'Days'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>decimal = h + m ÷ 60 + s ÷ 3600</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
