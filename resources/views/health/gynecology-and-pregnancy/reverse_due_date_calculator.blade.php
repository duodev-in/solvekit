<x-calc.page
    title="Reverse Due Date Calculator - SolveKit"
    description="Free reverse due date calculator: the first day of the last period and the likely conception date from a due date."
    lede="Work back from a due date."
    about="Working back from the due date: the last menstrual period started 280 days before it, and conception was about 266 days before it (around ovulation). Conception dates are estimates within a few days, because ovulation and implantation timing vary. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pregnancy', 'fields' => ['due', 'today'], 'focus' => 'reverse', 'method' => 'due']"
    :how-to="[
        ['name' => 'Enter the due date', 'text' => ''],
        ['name' => 'Read the LMP and conception dates', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When was conception for a due date of 12 April 2027?', 'answer' => 'About Conception about Jul 20, 2026 (conception); the LMP date is Jul 6, 2026.'],
    ]"
>
    <x-calc.field name="due" label="Due date" value="2027-04-12" type="date" />

    <x-calc.field name="today" label="As of" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="First day of last period" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2027-04-12', 'today' => '2026-10-19'],
        'Christmas baby' => ['lmp' => '2026-07-06', 'cycle' => 28, 'conception' => '2026-07-20', 'transfer' => '2026-07-25', 'embryo' => '5', 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 2, 'due' => '2026-12-25', 'today' => '2026-10-19'],
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
            <li>LMP = EDD − 280 days</li>
            <li>conception ≈ EDD − 266 days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
