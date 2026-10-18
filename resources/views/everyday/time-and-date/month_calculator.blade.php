<x-calc.page
    title="Month Calculator | Month Counter - SolveKit"
    description="Free month calculator: whole months between two dates, the days left over, fractional months and average-length months."
    lede="Count the months between two dates."
    about="Whole months are counted on the calendar: from 15 January to 15 March is 2 months. The days left over are then shown, and as a share of the next month. Average months use 30.436875 days (365.2425 ÷ 12), useful for rough comparisons."
    :calc="['engine' => 'ev-time', 'tool' => 'months_between', 'fields' => ['start', 'end']]"
    :how-to="[
        ['name' => 'Enter both dates', 'text' => 'In any order.'],
    ]"
    :faqs="[
        ['question' => 'How many months from 15 January to 18 October?', 'answer' => '9 months and 3 days.'],
        ['question' => 'How long is an average month?', 'answer' => '30.44 days on the Gregorian calendar.'],
        ['question' => 'What is 31 January to 28 February?', 'answer' => '28 days, short of a whole month by the calendar method.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Start date" value="2026-01-15" type="date" />
        <x-calc.field name="end" label="End date" value="2026-10-18" type="date" />
    </div>

    <x-calc.result label="Months between" />

    <x-calc.options :decimals="false" :examples="[
        '15 Jan to 18 Oct 2026' => ['start' => '2026-01-15', 'end' => '2026-10-18'],
        'A lease' => ['start' => '2025-09-01', 'end' => '2027-08-31'],
        'End of January' => ['start' => '2026-01-31', 'end' => '2026-02-28'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'exact' => ['label' => 'Fractional months'],
            'average' => ['label' => 'Average months'],
            'ymd' => ['label' => 'Years, months and days'],
            'days' => ['label' => 'Days'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>whole months = calendar months from start to end</li>
            <li>average months = days ÷ 30.436875</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
