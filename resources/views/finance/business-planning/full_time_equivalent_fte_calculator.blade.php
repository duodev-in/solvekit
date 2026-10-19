<x-calc.page
    title="Full-time Equivalent (FTE) Calculator - SolveKit"
    description="Free Full-time Equivalent (FTE) Calculator: FTE = total hours ÷ full-time hours. Full-time equivalents express part-time hours as a number of full-time staff."
    lede="Work out the FTE from total hours worked by all staff and full-time hours in the period."
    about="Full-time equivalents express part-time hours as a number of full-time staff. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'full_time_equivalent_fte', 'fields' => ['hours', 'fulltime']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total hours worked by all staff, Full-time hours in the period.'],
        ['name' => 'Read the result', 'text' => 'The FTE appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the FTE?', 'answer' => 'FTE = total hours ÷ full-time hours.'],
        ['question' => 'What is the FTE for total hours worked by all staff 1200, full-time hours in the period 160?', 'answer' => '7.5.'],
        ['question' => 'And for total hours worked by all staff 3000, full-time hours in the period 2080?', 'answer' => '1.442.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 40-hour week is 2,080 hours a year; the ACA counts 30 hours a week as full time.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hours" label="Total hours worked by all staff" value="1200" min="0" step="any" suffix="hours" />
        <x-calc.field name="fulltime" label="Full-time hours in the period" value="160" min="0" step="any" suffix="hours" />
    </div>

    <x-calc.result label="FTE" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['hours' => 1200, 'fulltime' => 160],
        'Example B' => ['hours' => 3000, 'fulltime' => 2080],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FTE = total hours ÷ full-time hours</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
