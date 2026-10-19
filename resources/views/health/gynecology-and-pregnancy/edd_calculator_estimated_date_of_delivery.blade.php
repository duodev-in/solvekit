<x-calc.page
    title="EDD Calculator - Estimated Date of Delivery - SolveKit"
    description="Free EDD calculator: estimated date of delivery from the last period and from an ultrasound, and which one to use by the ACOG redating rules."
    lede="Decide the estimated date of delivery."
    about="ACOG Committee Opinion 700 (2017, with AIUM and SMFM) says to keep the LMP due date unless the earliest ultrasound differs by more than: 5 days up to 8+6 weeks, 7 days at 9+0–15+6, 10 days at 16+0–21+6, 14 days at 22+0–27+6 and 21 days from 28 weeks. Once set, the EDD should not change with later scans. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'edd_compare', 'fields' => ['lmp', 'cycle', 'scan', 'scan_weeks', 'scan_days']]"
    :how-to="[
        ['name' => 'Enter the last period', 'text' => ''],
        ['name' => 'Enter the first scan', 'text' => 'Date and the gestational age it measured.'],
    ]"
    :faqs="[
        ['question' => 'Should a due date from LMP 6 July 2026 be changed by a scan on 1 September showing 7+0 weeks?', 'answer' => 'Apr 20, 2027: Use the ultrasound date: it differs from LMP dating by 8 days (more than 5 at up to 8+6 weeks).'],
        ['question' => 'And if the scan showed 8+4?', 'answer' => 'Keep the LMP date: the scan agrees within 5 days at up to 8+6 weeks.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lmp" label="First day of last period" value="2026-07-06" type="date" />
        <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="scan" label="Scan date" value="2026-09-01" type="date" />
        <x-calc.field name="scan_weeks" label="Weeks on the scan" value="7" min="0" max="42" step="1" suffix="weeks" />
        <x-calc.field name="scan_days" label="Days" value="0" min="0" max="6" step="1" suffix="days" />
    </div>

    <x-calc.result label="Estimated date of delivery" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28, 'scan' => '2026-09-01', 'scan_weeks' => 7, 'scan_days' => 0],
        'Agrees' => ['lmp' => '2026-07-06', 'cycle' => 28, 'scan' => '2026-09-01', 'scan_weeks' => 8, 'scan_days' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lmp' => ['label' => 'By last period'],
            'us' => ['label' => 'By ultrasound'],
            'difference' => ['label' => 'Difference'],
            'rule' => ['label' => 'ACOG rule'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>redate if |EDD(LMP) − EDD(US)| > threshold</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
