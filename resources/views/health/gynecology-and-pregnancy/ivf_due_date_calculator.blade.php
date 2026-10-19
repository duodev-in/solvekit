<x-calc.page
    title="IVF Due Date Calculator - SolveKit"
    description="Free IVF due date calculator: due date from the embryo transfer date and embryo age (day 3, 5 or 6), with how far along you are now."
    lede="Work out an IVF due date."
    about="With IVF the conception date is known exactly. Due date = transfer date + 266 days − the embryo's age in days: transfer + 263 days for a day-3 embryo and + 261 days for a day-5 blastocyst. Frozen and fresh transfers are dated the same way. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pregnancy', 'fields' => ['transfer', 'embryo', 'today'], 'method' => 'ivf']"
    :how-to="[
        ['name' => 'Enter the transfer date', 'text' => ''],
        ['name' => 'Choose the embryo age', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When is a day-5 transfer on 25 July 2026 due?', 'answer' => 'Apr 12, 2027.'],
        ['question' => 'And a day-3 transfer?', 'answer' => 'Apr 14, 2027.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="transfer" label="Embryo transfer date" value="2026-07-25" type="date" />
        <x-calc.select name="embryo" label="Embryo age at transfer" :options="['3' => 'Day 3', '5' => 'Day 5 (blastocyst)', '6' => 'Day 6']" selected="5" />
    </div>

    <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Estimated due date" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19'],
        'Day 3' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '3', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19'],
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
            <li>EDD = transfer + 266 − embryo days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
