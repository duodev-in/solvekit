<x-calc.page
    title="Implantation Calculator - SolveKit"
    description="Free implantation calculator: when the embryo is likely to implant after ovulation, and when a pregnancy test may turn positive."
    lede="Estimate implantation day."
    about="In the study by Wilcox, Baird & Weinberg (N Engl J Med 1999), implantation happened 6–12 days after ovulation, and 84% of pregnancies implanted on days 8–10. hCG rises after implantation, so sensitive tests may turn positive a few days later. Light spotting around this time is common but not universal. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'implantation', 'fields' => ['know', 'lmp', 'cycle', 'ovulation']]"
    :how-to="[
        ['name' => 'Enter your last period or ovulation', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'When might implantation happen after ovulation on 20 July 2026?', 'answer' => 'Jul 28, 2026 – Jul 30, 2026.'],
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

    <x-calc.result label="Most likely implantation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['know' => 'lmp', 'lmp' => '2026-07-06', 'cycle' => 28, 'ovulation' => '2026-07-20'],
        'Ovulation' => ['know' => 'ovulation', 'lmp' => '2026-07-06', 'cycle' => 28, 'ovulation' => '2026-07-20'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ovulation' => ['label' => 'Ovulation'],
            'window' => ['label' => 'Possible window'],
            'test' => ['label' => 'Testing'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>implantation ≈ ovulation + 8–10 days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
