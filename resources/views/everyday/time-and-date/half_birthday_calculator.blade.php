<x-calc.page
    title="Half Birthday Calculator - SolveKit"
    description="Free half birthday calculator: the date six months after your birthday, days until your next half birthday and your half age."
    lede="Find your half birthday and how long until the next one."
    about="A half birthday is six calendar months after your birthday. When that month is shorter (a 31 August birthday), it falls on the month's last day: 28 or 29 February. Some people use 182 or 183 days instead, which can differ by a day or two."
    :calc="['engine' => 'ev-time', 'tool' => 'half_birthday', 'fields' => ['birth', 'on']]"
    :how-to="[
        ['name' => 'Enter the birth date', 'text' => 'See the half birthday.'],
    ]"
    :faqs="[
        ['question' => 'When is my half birthday?', 'answer' => 'Six months after your birthday: 15 May → 15 November.'],
        ['question' => 'What about 31 August?', 'answer' => 'There is no 31 February, so the last day of February.'],
        ['question' => 'Why celebrate half birthdays?', 'answer' => 'Often for children with birthdays in the holidays or summer break.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="2012-08-31" type="date" />

    <x-calc.field name="on" label="Today" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Next half birthday" />

    <x-calc.options :decimals="false" :examples="[
        'Born 31 August' => ['birth' => '2012-08-31', 'on' => '2026-10-18'],
        'Born 15 May' => ['birth' => '2019-05-15', 'on' => '2026-10-18'],
        'Christmas birthday' => ['birth' => '2016-12-25', 'on' => '2026-10-18'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'left' => ['label' => 'Days to go'],
            'age' => ['label' => 'Half age'],
            'rule' => ['label' => 'How it is found'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>half birthday = birthday + 6 months (last day of the month if shorter)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
