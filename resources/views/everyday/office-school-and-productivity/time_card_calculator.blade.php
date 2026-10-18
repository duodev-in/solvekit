<x-calc.page
    title="Time Card Calculator - SolveKit"
    description="Free time card calculator: hours worked in a week from clock-in and clock-out times with breaks, overtime over 40 hours or 8 a day, and pay."
    lede="Total a weekly time card, with overtime and pay."
    about="Hours each day = clock-out − clock-in − unpaid break (overnight shifts are handled). Under the US Fair Labor Standards Act, non-exempt employees earn 1.5× pay for hours over 40 in a week; some states, such as California, also count hours over 8 in a day. Check your state's rules."
    :calc="['engine' => 'ev-office', 'tool' => 'time_card', 'fields' => ['days', 'rate', 'rule']]"
    :how-to="[
        ['name' => 'Enter each day', 'text' => 'Times like 09:00 and 17:30, and break minutes.'],
        ['name' => 'Enter your rate', 'text' => 'And the overtime rule.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate hours on a time card?', 'answer' => 'Out − in − unpaid breaks for each day, then add the days.'],
        ['question' => 'When is overtime paid?', 'answer' => 'Over 40 hours a week under federal law.'],
        ['question' => 'How do I enter an overnight shift?', 'answer' => 'Enter the times as they are, e.g. 22:00 to 06:00.'],
    ]"
>
    <x-calc.rows-editor name="days" label="Time card" :columns="['day' => 'Day', 'start' => 'In', 'end' => 'Out', 'lunch' => 'Break min']" :rows="[['Monday', '09:00', '17:30', 30], ['Tuesday', '08:45', '17:15', 30], ['Wednesday', '09:00', '18:00', 45], ['Thursday', '09:00', '17:30', 30], ['Friday', '09:00', '16:00', 30]]" add-label="Add day" :text="['day', 'start', 'end']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Hourly rate (optional)" value="22" min="0" step="0.01" suffix="$" />
        <x-calc.select name="rule" label="Overtime" :options="['weekly' => 'Over 40 hours a week', 'daily' => 'Over 8 a day or 40 a week', 'none' => 'No overtime']" selected="weekly" />
    </div>

    <x-calc.result label="Hours worked" />

    <x-calc.options :examples="[
        'Standard week' => ['days' => 'Monday	09:00	17:30	30
Tuesday	08:45	17:15	30
Wednesday	09:00	18:00	45
Thursday	09:00	17:30	30
Friday	09:00	16:00	30', 'rate' => 22, 'rule' => 'weekly'],
        'Long week with overtime' => ['days' => 'Mon	07:00	18:00	30
Tue	07:00	18:00	30
Wed	07:00	17:00	30
Thu	07:00	18:30	30
Fri	07:00	15:00	0', 'rate' => 25, 'rule' => 'daily'],
        'Night shifts' => ['days' => 'Mon	22:00	06:00	30
Tue	22:00	06:00	30
Wed	22:00	06:00	30', 'rate' => 20, 'rule' => 'weekly'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'regular' => ['label' => 'Regular'],
            'overtime' => ['label' => 'Overtime'],
            'pay' => ['label' => 'Pay'],
        ]" />
        <x-calc.quick-ref heading="Each day" name="days" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = out − in − break</li>
            <li>overtime = hours over 40 (or over 8 a day)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
