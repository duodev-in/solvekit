<x-calc.page
    title="Gestational Age Calculator - SolveKit"
    description="Free gestational age calculator: how many weeks and days pregnant you are on any date, from the last period, the due date or an ultrasound."
    lede="Find how many weeks pregnant you are."
    about="Gestational age is counted from the first day of the last menstrual period, about two weeks before conception, so a “4 weeks pregnant” embryo is about 2 weeks old. It is written as weeks+days, for example 14+3. The first trimester runs to 13+6, the second to 27+6 and the third from 28 weeks. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pregnancy', 'fields' => ['method', 'lmp', 'cycle', 'due', 'scan', 'scan_weeks', 'scan_days', 'today'], 'focus' => 'age']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => ''],
        ['name' => 'Enter the date and the “as of” date', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How far along is a pregnancy with LMP 6 July 2026, on 19 October 2026?', 'answer' => '15 weeks 0 days (Second trimester; due Apr 12, 2027).'],
        ['question' => 'And due 12 April 2027?', 'answer' => '15 weeks 0 days.'],
    ]"
>
    <x-calc.segmented name="method" legend="Date from" :options="['lmp' => 'Last period', 'due' => 'Due date', 'ultrasound' => 'Ultrasound']" selected="lmp" />

    <div data-show-when="method:lmp">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="lmp" label="First day of last period" value="2026-07-06" type="date" />
            <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
        </div>
    </div>

    <div data-show-when="method:due" hidden>
        <x-calc.field name="due" label="Due date" value="2027-04-12" type="date" />
    </div>

    <div data-show-when="method:ultrasound" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="scan" label="Scan date" value="2026-09-01" type="date" />
            <x-calc.field name="scan_weeks" label="Weeks on the scan" value="8" min="0" max="42" step="1" suffix="weeks" />
            <x-calc.field name="scan_days" label="Days" value="2" min="0" max="6" step="1" suffix="days" />
        </div>
    </div>

    <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Gestational age" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'lmp'],
        'By due date' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'due'],
        'By scan' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'ultrasound'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'due' => ['label' => 'Due date'],
            'lmp' => ['label' => 'LMP date'],
            'conception' => ['label' => 'Conception'],
            'now' => ['label' => 'Gestational age now'],
            'trimester' => ['label' => 'Trimester'],
            'left' => ['label' => 'Days to go'],
            'basis' => ['label' => 'Dated from'],
        ]" />
        <x-calc.grid heading="Milestones" name="milestones" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GA = date − LMP</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
