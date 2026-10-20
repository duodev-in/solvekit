<x-calc.page
    title="Time Percentage Calculator - SolveKit"
    description="Free time percentage calculator: what percentage one time span is of another, from hours, minutes and seconds."
    lede="Find what percent of the time has passed."
    about="Convert both times to seconds, then divide: 1:30:00 of 8:00:00 is 5,400 ÷ 28,800 = 18.75%. Times can be typed as h:mm:ss, mm:ss or decimal hours."
    :calc="['engine' => 'mt-percent', 'tool' => 'time', 'fields' => ['part', 'total']]"
    :how-to="[
        ['name' => 'Enter the part and the total', 'text' => 'As h:mm:ss, mm:ss or hours.'],
    ]"
    :faqs="[
        ['question' => 'What percent of an 8-hour day is 1 hour 30 minutes?', 'answer' => '18.75%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="part" label="Part of the time" value="1:30:00" type="text" inputmode="text" />
        <x-calc.field name="total" label="Total time" value="8:00:00" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Of the total time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['part' => '1:30:00', 'total' => '8:00:00'],
        'Race' => ['part' => '12:45', 'total' => '50:00'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'part' => ['label' => 'Part'],
            'total' => ['label' => 'Total'],
            'rest' => ['label' => 'Remaining time'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>p = part ÷ total × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
