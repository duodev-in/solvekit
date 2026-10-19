<x-calc.page
    title="Conception Calculator - SolveKit"
    description="Free conception calculator: the likely date of conception and the fertile window from your due date or last period."
    lede="Estimate when you conceived."
    about="Conception usually happens within a day of ovulation, about 14 days after the last period in a 28-day cycle, or 266 days before the due date. Sperm can survive up to 5 days, so intercourse in the 5 days before ovulation can lead to pregnancy (Wilcox et al. 1995). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pregnancy', 'fields' => ['method', 'due', 'lmp', 'cycle', 'today'], 'focus' => 'conception']"
    :how-to="[
        ['name' => 'Enter the due date or last period', 'text' => ''],
        ['name' => 'Read the conception date and fertile window', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When was a baby due on 12 April 2027 conceived?', 'answer' => 'Jul 20, 2026 (Most likely fertile window Jul 15, 2026 – Jul 20, 2026).'],
    ]"
>
    <x-calc.segmented name="method" legend="Date from" :options="['due' => 'Due date', 'lmp' => 'Last period']" selected="due" />

    <div data-show-when="method:due">
        <x-calc.field name="due" label="Due date" value="2027-04-12" type="date" />
    </div>

    <div data-show-when="method:lmp" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="lmp" label="First day of last period" value="2026-07-06" type="date" />
            <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
        </div>
    </div>

    <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Likely conception date" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'due'],
        'From LMP' => ['lmp' => '2026-07-06', 'cycle' => 30, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19', 'method' => 'lmp'],
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
            <li>conception ≈ EDD − 266 days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
