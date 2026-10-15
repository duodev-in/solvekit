@php
    $units = config('units.time');
@endphp

<x-calc.page
    title="Minutes to Hours Converter - SolveKit"
    description="Professional minutes to hours converter for time calculations. Convert between minutes and hours with decimal precision and practical time examples."
    lede="Convert minutes to hours, or hours to minutes, as decimals and as hours and minutes."
    about="An hour has 60 minutes, so minutes are divided by 60 for decimal hours and hours are multiplied by 60 for minutes. The clock form rounds to the nearest whole minute first, so 119.6 minutes reads 2:00, never 1:60."
    :calc="['engine' => 'minutes-hours', 'units' => $units, 'list' => ['s', 'day', 'week'], 'quickRef' => ['min:h' => [15, 30, 45, 90, 120, 480], 'h:min' => [0.25, 0.5, 0.75, 1.5, 2, 8]], 'min' => 0]"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Minutes to hours, or hours to minutes.'],
        ['name' => 'Enter the time', 'text' => 'Decimal hours, the clock form and working days update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert minutes to hours?', 'answer' => 'Divide by 60. 90 minutes is 1.5 hours, or 1:30.'],
        ['question' => 'What is 0.75 hours in minutes?', 'answer' => '45 minutes.'],
        ['question' => 'How do I enter time on a timesheet?', 'answer' => 'Many timesheets want decimal hours: 7 hours 45 minutes is 7.75 hours.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['min:h' => 'Minutes → Hours', 'h:min' => 'Hours → Minutes']" selected="min:h" />

    <x-calc.field name="value" label="Time" value="135" min="0" suffix="min" suffix-ref="value-suffix" placeholder="Enter a time" />

    <x-calc.result label="Hours" />

    <x-calc.options :examples="[
        'Meeting 45 min' => ['value' => 45, 'direction' => 'min:h'],
        'Shift 7.75 h' => ['value' => 7.75, 'direction' => 'h:min'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Same time as" :rows="[
            'clock' => ['label' => 'Hours and minutes (H:MM)'],
            'worded' => ['label' => 'In words'],
            'workdays' => ['label' => '8-hour working days', 'unit' => 'days'],
        ]" />
        <x-calc.unit-list :grow="false" :units="$units" :keys="['s', 'day', 'week']" heading="135 min in other units" />
        <x-calc.quick-ref />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = minutes ÷ 60</li>
            <li>minutes = hours × 60</li>
            <li>H:MM = whole hours : remaining minutes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
