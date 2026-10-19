<x-calc.page
    title="Luteal Phase Calculator - SolveKit"
    description="Free luteal phase calculator: length of the luteal phase (ovulation to the next period) from your cycle length and ovulation day."
    lede="Work out your luteal phase."
    about="The luteal phase runs from ovulation to the day before the next period and is usually 11–16 days, more constant than the follicular phase before it. Luteal phase length = cycle length − ovulation day (day 1 is the first day of bleeding). A phase under 10 days is often called short; its effect on fertility is debated (ASRM 2021). For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'luteal', 'fields' => ['cycle', 'ov_day']]"
    :how-to="[
        ['name' => 'Enter cycle length', 'text' => ''],
        ['name' => 'Enter the ovulation day', 'text' => 'From a test, BBT or scan.'],
    ]"
    :faqs="[
        ['question' => 'How long is the luteal phase with a 28-day cycle and ovulation on day 15?', 'answer' => '13 days: Within the typical 11–16 days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cycle" label="Cycle length" value="28" min="20" max="45" step="1" suffix="days" />
        <x-calc.field name="ov_day" label="Ovulation on cycle day" value="15" min="5" max="40" step="1" />
    </div>

    <x-calc.result label="Luteal phase" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cycle' => 28, 'ov_day' => 15],
        'Short' => ['cycle' => 26, 'ov_day' => 18],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'follicular' => ['label' => 'Follicular phase'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>luteal = cycle − ovulation day</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
