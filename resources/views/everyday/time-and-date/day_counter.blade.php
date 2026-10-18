<x-calc.page
    title="Day Counter - SolveKit"
    description="Free day counter: count the days between two dates, with weekdays, weekend days, full weeks and how many of each weekday."
    lede="Count the days, weekdays and weekend days between two dates."
    about="Each day from the start up to (or including) the end date is counted and sorted by weekday. Weekdays are Monday to Friday. For working days with holidays, use the Business Days calculator."
    :calc="['engine' => 'ev-time', 'tool' => 'day_counter', 'fields' => ['start', 'end', 'include_end']]"
    :how-to="[
        ['name' => 'Enter the two dates', 'text' => 'Today is filled in as the start.'],
        ['name' => 'Choose whether to count the end date', 'text' => 'Ticked by default.'],
    ]"
    :faqs="[
        ['question' => 'How many weekdays are in 2026?', 'answer' => '261 (365 days, starting on a Thursday).'],
        ['question' => 'Does it count today?', 'answer' => 'The start date is always counted; tick to count the end date too.'],
        ['question' => 'Can I count backwards?', 'answer' => 'Yes; the dates can be in either order.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start date" value="{{ now()->toDateString() }}" type="date" />
        <x-calc.field name="end" label="End date" value="2026-12-31" type="date" />
    </div>

    <x-calc.checkbox name="include_end" label="Count the end date too" :checked="true" />

    <x-calc.result label="Days" />

    <x-calc.options :decimals="false" :examples="[
        'Rest of 2026' => ['start' => '2026-10-18', 'end' => '2026-12-31', 'include_end' => true],
        'All of 2026' => ['start' => '2026-01-01', 'end' => '2026-12-31', 'include_end' => true],
        'School term' => ['start' => '2026-09-02', 'end' => '2026-12-18', 'include_end' => true],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'weekdays' => ['label' => 'Weekdays'],
            'weekend' => ['label' => 'Weekend days'],
            'weeks' => ['label' => 'Full weeks'],
        ]" />
        <x-calc.quick-ref heading="Each weekday" name="weekdays" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days = end − start (+1 counting the end)</li>
            <li>weekdays = days that are Monday–Friday</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
