<x-calc.page
    title="Clomid Ovulation Calculator - SolveKit"
    description="Free Clomid ovulation calculator: the expected ovulation window after a course of clomiphene taken on cycle days 3–7 or 5–9."
    lede="Predict ovulation on Clomid."
    about="After clomiphene citrate, ovulation usually happens 5–10 days after the last tablet: around cycle days 12–17 for days 3–7 and 14–19 for days 5–9. Clinics often advise ovulation tests a couple of days after the last tablet and intercourse every one to two days through the window. Take it only as prescribed. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'clomid', 'fields' => ['start', 'days']]"
    :how-to="[
        ['name' => 'Enter cycle day 1', 'text' => ''],
        ['name' => 'Choose the tablet days', 'text' => 'As prescribed.'],
    ]"
    :faqs="[
        ['question' => 'When is ovulation likely after tablets on days 5–9 from 1 October 2026?', 'answer' => 'Oct 14, 2026 – Oct 19, 2026.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Cycle day 1 (first day of period)" value="2026-10-01" type="date" />
        <x-calc.select name="days" label="Tablets taken on" :options="['3' => 'Days 3–7', '5' => 'Days 5–9']" selected="5" />
    </div>

    <x-calc.result label="Expected ovulation window" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['start' => '2026-10-01', 'days' => '5'],
        'Days 3–7' => ['start' => '2026-10-01', 'days' => '3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'tablets' => ['label' => 'Tablets'],
            'tests' => ['label' => 'Ovulation tests'],
            'intercourse' => ['label' => 'Timing'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ovulation ≈ last tablet + 5–10 days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
