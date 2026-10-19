<x-calc.page
    title="Period Calculator - SolveKit"
    description="Free period calculator: the dates of your next six periods and fertile windows from your last period, cycle length and period length."
    lede="Predict your next periods."
    about="Each period starts one cycle length after the last; the fertile window ends about 13 days before the next period. ACOG describes adult cycles of 21–35 days and periods lasting up to 7 days as typical; cycles that change a lot, or bleeding between periods, are worth discussing with a doctor. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'period', 'fields' => ['lmp', 'cycle', 'length']]"
    :how-to="[
        ['name' => 'Enter your last period', 'text' => ''],
        ['name' => 'Enter cycle and period length', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When is the next period after 6 July 2026 with a 28-day cycle?', 'answer' => 'Aug 3, 2026.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="lmp" label="First day of last period" value="2026-07-06" type="date" />
        <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
        <x-calc.field name="length" label="Period length" value="5" min="1" max="10" step="1" suffix="days" />
    </div>

    <x-calc.result label="Next period starts" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lmp' => '2026-07-06', 'cycle' => 28, 'length' => 5],
        'Short cycle' => ['lmp' => '2026-07-06', 'cycle' => 24, 'length' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cycle' => ['label' => 'Cycle'],
            'fertile' => ['label' => 'Fertile window'],
            'normal' => ['label' => 'Typical'],
        ]" />
        <x-calc.grid heading="Upcoming periods" name="periods" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>next = LMP + cycle</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
