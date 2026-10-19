<x-calc.page
    title="Pregnancy Test Calculator - SolveKit"
    description="Free pregnancy test calculator: the earliest day a home pregnancy test may work and the most reliable day to test, from your last period or ovulation."
    lede="Find when to take a pregnancy test."
    about="Home tests detect hCG, which appears after implantation (6–12 days after ovulation). Testing on the day of the missed period (about 14 days after ovulation) is reliable for most tests; very sensitive tests may turn positive a few days earlier, but a negative early result should be repeated. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pregnancy_test', 'fields' => ['know', 'lmp', 'cycle', 'ovulation']]"
    :how-to="[
        ['name' => 'Enter your last period or ovulation', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When should I test if my last period was 6 July 2026?', 'answer' => 'From Aug 3, 2026; Early sensitive tests may work from Jul 30, 2026; a negative early test should be repeated.'],
    ]"
>
    <x-calc.segmented name="know" legend="I know" :options="['lmp' => 'My last period', 'ovulation' => 'My ovulation date']" selected="lmp" />

    <div data-show-when="know:lmp">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="lmp" label="First day of last period" value="2026-07-06" type="date" />
            <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
        </div>
    </div>

    <div data-show-when="know:ovulation" hidden>
        <x-calc.field name="ovulation" label="Ovulation date" value="2026-07-20" type="date" />
    </div>

    <x-calc.result label="Test from" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['know' => 'lmp', 'lmp' => '2026-07-06', 'cycle' => 28, 'ovulation' => '2026-07-20'],
        'Ovulation' => ['know' => 'ovulation', 'lmp' => '2026-07-06', 'cycle' => 28, 'ovulation' => '2026-07-25'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'earliest' => ['label' => 'Earliest'],
            'missed' => ['label' => 'Missed period'],
            'reliable' => ['label' => 'Most reliable'],
            'ovulation' => ['label' => 'Ovulation'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>missed period ≈ ovulation + 14 days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
