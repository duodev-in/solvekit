<x-calc.page
    title="Due Date Calculator - SolveKit"
    description="Free due date calculator: your estimated due date from the last period (any cycle length), conception date, IVF transfer or an ultrasound, with how many weeks you are now and key milestones."
    lede="Work out your due date."
    about="Naegele's rule: the due date is 280 days (40 weeks) after the first day of the last menstrual period, moved later or earlier by the difference between your cycle length and 28 days. From conception it is 266 days; after IVF, transfer date + 266 days − the embryo's age; from a scan, the scan date + 280 days − the gestational age measured. Only about 4% of babies arrive on the due date; most come within two weeks either side. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pregnancy', 'fields' => ['method', 'lmp', 'cycle', 'conception', 'transfer', 'embryo', 'scan', 'scan_weeks', 'scan_days', 'today']]"
    :how-to="[
        ['name' => 'Choose how to date the pregnancy', 'text' => 'Ultrasound in the first trimester is the most accurate.'],
        ['name' => 'Enter the date', 'text' => ''],
        ['name' => 'Read the due date and milestones', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When is the baby due if the last period started on 6 July 2026?', 'answer' => 'Apr 12, 2027 (15+0 weeks today; second trimester, as of 19 October 2026).'],
        ['question' => 'And with a 32-day cycle?', 'answer' => 'Apr 16, 2027.'],
    ]"
>
    <x-calc.segmented name="method" legend="Date from" :options="['lmp' => 'Last period', 'conception' => 'Conception date', 'ivf' => 'IVF transfer', 'ultrasound' => 'Ultrasound']" selected="lmp" />

    <div data-show-when="method:lmp">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="lmp" label="First day of last period" value="2026-07-06" type="date" />
            <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
        </div>
    </div>

    <div data-show-when="method:conception" hidden>
        <x-calc.field name="conception" label="Conception date" value="2026-07-20" type="date" />
    </div>

    <div data-show-when="method:ivf" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="transfer" label="Embryo transfer date" value="2026-07-25" type="date" />
            <x-calc.select name="embryo" label="Embryo age at transfer" :options="['3' => 'Day 3', '5' => 'Day 5 (blastocyst)', '6' => 'Day 6']" selected="5" />
        </div>
    </div>

    <div data-show-when="method:ultrasound" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="scan" label="Scan date" value="2026-09-01" type="date" />
            <x-calc.field name="scan_weeks" label="Weeks on the scan" value="8" min="0" max="42" step="1" suffix="weeks" />
            <x-calc.field name="scan_days" label="Days" value="2" min="0" max="6" step="1" suffix="days" />
        </div>
    </div>

    <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Estimated due date" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'lmp'],
        'Long cycle' => ['lmp' => '2026-07-06', 'cycle' => 32, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'lmp'],
        'IVF day 5' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'ivf'],
        'Ultrasound' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'ultrasound'],
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
            <li>EDD = LMP + 280 days + (cycle − 28)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
