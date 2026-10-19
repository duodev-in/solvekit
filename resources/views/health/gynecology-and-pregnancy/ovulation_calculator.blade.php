<x-calc.page
    title="Ovulation Calculator - SolveKit"
    description="Free ovulation calculator: your most fertile days and estimated ovulation date from your last period and cycle length, for the next six cycles."
    lede="Find your fertile days."
    about="Ovulation usually happens about 14 days before the next period, so in a 28-day cycle around day 14 and in a 32-day cycle around day 18. The fertile window is the 5 days before ovulation and the day of it; the 2 days before ovulation are the most fertile (Wilcox et al. 1995). Ovulation tests and cervical mucus help pinpoint it. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'ovulation', 'fields' => ['lmp', 'cycle']]"
    :how-to="[
        ['name' => 'Enter the first day of your last period', 'text' => ''],
        ['name' => 'Enter your usual cycle length', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When is ovulation for a period on 6 July 2026 and a 28-day cycle?', 'answer' => 'Jul 20, 2026 (Fertile window Jul 15, 2026 – Jul 21, 2026; next period Aug 3, 2026).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lmp" label="First day of last period" value="2026-07-06" type="date" />
        <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
    </div>

    <x-calc.result label="Estimated ovulation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28],
        'Long cycle' => ['lmp' => '2026-07-06', 'cycle' => 34],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fertile' => ['label' => 'Fertile window'],
            'peak' => ['label' => 'Most fertile'],
            'next' => ['label' => 'Next period'],
            'test' => ['label' => 'Ovulation tests'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="Next cycles" name="cycles" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ovulation ≈ LMP + cycle − 14</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
