<x-calc.page
    title="Time Calculator - SolveKit"
    description="Free time calculator: add or subtract two durations in days, hours, minutes and seconds, or multiply and divide a duration by a number."
    lede="Add, subtract, multiply or divide lengths of time."
    about="Durations are turned into seconds, combined, and written back as days, hours, minutes and seconds, so minutes carry over every 60 and hours every 24. Use multiply for repeated tasks (45 minutes × 12) and divide to split time (a 26.2-mile run time ÷ 26.2 for pace)."
    :calc="['engine' => 'ev-time', 'tool' => 'time_calc', 'fields' => ['a_days', 'a_hours', 'a_minutes', 'a_seconds', 'operation', 'b_days', 'b_hours', 'b_minutes', 'b_seconds', 'factor']]"
    :how-to="[
        ['name' => 'Enter the first time', 'text' => 'Days, hours, minutes and seconds.'],
        ['name' => 'Choose the operation', 'text' => 'And the second time or a number.'],
    ]"
    :faqs="[
        ['question' => 'What is 2:45:30 + 1:30:45?', 'answer' => '4 h 16 min 15 s.'],
        ['question' => 'What is 45 minutes × 12?', 'answer' => '9 hours.'],
        ['question' => 'How do I find a marathon pace?', 'answer' => 'Divide the finish time by 26.2: 4 hours ÷ 26.2 ≈ 9 min 10 s per mile.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="a_days" label="Days" value="0" min="0" step="1" />
        <x-calc.field name="a_hours" label="Hours" value="2" min="0" step="1" />
        <x-calc.field name="a_minutes" label="Minutes" value="45" min="0" step="1" />
        <x-calc.field name="a_seconds" label="Seconds" value="30" min="0" step="1" />
    </div>

    <x-calc.segmented name="operation" legend="Operation" :options="['add' => '+', 'subtract' => '−', 'multiply' => '×', 'divide' => '÷']" selected="add" />

    <div data-show-when="operation:add,subtract">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <x-calc.field name="b_days" label="Days" value="0" min="0" step="1" />
            <x-calc.field name="b_hours" label="Hours" value="1" min="0" step="1" />
            <x-calc.field name="b_minutes" label="Minutes" value="30" min="0" step="1" />
            <x-calc.field name="b_seconds" label="Seconds" value="45" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="operation:multiply,divide" hidden>
        <x-calc.field name="factor" label="Number" value="4" step="any" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '2:45:30 + 1:30:45' => ['a_days' => 0, 'a_hours' => 2, 'a_minutes' => 45, 'a_seconds' => 30, 'operation' => 'add', 'b_days' => 0, 'b_hours' => 1, 'b_minutes' => 30, 'b_seconds' => 45, 'factor' => ''],
        '45 min × 12' => ['a_days' => 0, 'a_hours' => 0, 'a_minutes' => 45, 'a_seconds' => 0, 'operation' => 'multiply', 'b_days' => 0, 'b_hours' => 0, 'b_minutes' => 0, 'b_seconds' => 0, 'factor' => 12],
        'Marathon pace' => ['a_days' => 0, 'a_hours' => 4, 'a_minutes' => 0, 'a_seconds' => 0, 'operation' => 'divide', 'b_days' => 0, 'b_hours' => 0, 'b_minutes' => 0, 'b_seconds' => 0, 'factor' => 26.2],
        '3 days − 30 h' => ['a_days' => 3, 'a_hours' => 0, 'a_minutes' => 0, 'a_seconds' => 0, 'operation' => 'subtract', 'b_days' => 0, 'b_hours' => 30, 'b_minutes' => 0, 'b_seconds' => 0, 'factor' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'hours' => ['label' => 'Hours'],
            'minutes' => ['label' => 'Minutes'],
            'seconds' => ['label' => 'Seconds'],
            'days' => ['label' => 'Days'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>seconds = days × 86,400 + hours × 3,600 + minutes × 60 + seconds</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
