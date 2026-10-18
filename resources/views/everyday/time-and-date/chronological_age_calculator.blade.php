<x-calc.page
    title="Chronological Age Calculator - SolveKit"
    description="Free chronological age calculator: age in years;months;days at a test date, by calendar and by the test-manual method of borrowing 30-day months."
    lede="Work out a child's chronological age on a test date."
    about="Chronological age is the time since birth on the test date, written years;months;days. Many test manuals subtract the birth date from the test date part by part, borrowing 30 days for a month and 12 months for a year; that can differ by a day or two from the calendar method. Some tests then round 16 or more days up to the next month. Use the method your test manual gives."
    :calc="['engine' => 'ev-time', 'tool' => 'chronological_age', 'fields' => ['birth', 'test']]"
    :how-to="[
        ['name' => 'Enter the birth date', 'text' => 'And the test date.'],
        ['name' => 'Read both methods', 'text' => 'Use the one your test manual specifies.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate chronological age?', 'answer' => 'Subtract the birth date from the test date: days, then months, then years, borrowing when needed.'],
        ['question' => 'Why borrow 30 days?', 'answer' => 'It is the convention in many test manuals so every examiner gets the same answer.'],
        ['question' => 'Do I round the days?', 'answer' => 'Some tests round 16 days or more up to the next month; check the manual.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="2018-09-23" type="date" />

    <x-calc.field name="test" label="Test date" value="2026-03-14" type="date" />

    <x-calc.result label="Chronological age" />

    <x-calc.options :decimals="false" :examples="[
        'Test in March 2026' => ['birth' => '2018-09-23', 'test' => '2026-03-14'],
        'Borrowing across February' => ['birth' => '2019-01-31', 'test' => '2026-03-01'],
        'Teenager' => ['birth' => '2011-12-05', 'test' => '2026-10-18'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'borrow' => ['label' => 'Test-manual method'],
            'rounded' => ['label' => 'Rounded to months'],
            'months' => ['label' => 'Total months'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>days = test day − birth day (+30, borrow a month, if negative)</li>
            <li>months = test month − birth month (+12, borrow a year, if negative)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
