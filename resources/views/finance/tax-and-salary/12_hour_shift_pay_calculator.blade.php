<x-calc.page
    title="12-Hour Shift Pay Calculator - SolveKit"
    description="Free 12-hour shift pay calculator: weekly pay for 12-hour shifts with overtime over 40 hours (or California daily rules) and a night differential."
    lede="Work out pay for 12-hour shifts."
    about="Three 12-hour shifts are 36 hours (no federal overtime); four are 48 hours, 8 of them overtime at 1.5×. Under California rules hours 9–12 of each shift are overtime. Hospitals often use 8/80 schedules instead; check your contract. Night differential is extra pay per night hour. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'shift12', 'fields' => ['rate', 'shifts', 'length', 'rules', 'night', 'night_hours']]"
    :how-to="[
        ['name' => 'Enter rate and shifts', 'text' => ''],
        ['name' => 'Choose overtime rules', 'text' => 'And any night differential.'],
    ]"
    :faqs="[
        ['question' => 'What do four 12-hour shifts pay at $35?', 'answer' => '$1,820.00.'],
        ['question' => 'And three shifts?', 'answer' => '$1,260.00.'],
        ['question' => 'Under California rules?', 'answer' => '$2,072.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rate" label="Hourly rate" value="35" step="0.01" suffix="$" />
        <x-calc.field name="shifts" label="Shifts a week" value="4" min="0" max="7" step="1" />
        <x-calc.field name="length" label="Shift length" value="12" min="1" step="any" suffix="hours" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="rules" label="Overtime rules" :options="['federal' => 'Federal (over 40 a week)', 'california' => 'California (daily)']" selected="federal" />
        <x-calc.field name="night" label="Night differential" value="10" step="any" suffix="%" />
        <x-calc.field name="night_hours" label="Night hours per shift" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Weekly pay" />

    <x-calc.options :decimals="false" :examples="[
        'Four shifts' => ['rate' => 35, 'shifts' => 4, 'length' => 12, 'rules' => 'federal', 'night' => 10, 'night_hours' => 0],
        'Three shifts' => ['rate' => 35, 'shifts' => 3, 'length' => 12, 'rules' => 'federal', 'night' => 10, 'night_hours' => 0],
        'California' => ['rate' => 35, 'shifts' => 4, 'length' => 12, 'rules' => 'california', 'night' => 10, 'night_hours' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'regular' => ['label' => 'Regular hours'],
            'overtime' => ['label' => 'Overtime hours'],
            'night' => ['label' => 'Night differential'],
            'yearly' => ['label' => 'Yearly'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>federal: OT = hours over 40</li>
            <li>California: OT = hours 8–12 each day, 2× over 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
