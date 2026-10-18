<x-calc.page
    title="Baby Age Calculator - SolveKit"
    description="Free baby age calculator: a baby's age in weeks, months and days, and the corrected (adjusted) age for babies born early."
    lede="Work out your baby's age in weeks and months, and the corrected age for a premature baby."
    about="Age in weeks = days since birth ÷ 7. For babies born before 37 weeks, doctors use the corrected (adjusted) age for development checks: the age minus the weeks born early, which is the same as the age counted from the due date (American Academy of Pediatrics). Corrected age is usually used until about 2 years."
    :calc="['engine' => 'ev-time', 'tool' => 'baby_age', 'fields' => ['birth', 'on', 'premature', 'due']]"
    :how-to="[
        ['name' => 'Enter the birth date', 'text' => 'And today\'s date or another date.'],
        ['name' => 'For a premature baby', 'text' => 'Tick born early and enter the due date.'],
    ]"
    :faqs="[
        ['question' => 'How do I work out corrected age?', 'answer' => 'Subtract the weeks born early from the age: a 16-week-old born 6 weeks early has a corrected age of 10 weeks.'],
        ['question' => 'Until when is corrected age used?', 'answer' => 'Usually until about 2 years old.'],
        ['question' => 'How many weeks is 3 months?', 'answer' => 'About 13 weeks.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="2026-06-01" type="date" />

    <x-calc.field name="on" label="Age on" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.checkbox name="premature" label="Born early (premature)" :checked="false" />

    <div data-show-when="premature:true" hidden>
        <x-calc.field name="due" label="Due date" value="2026-07-13" type="date" />
    </div>

    <x-calc.result label="Baby's age" />

    <x-calc.options :decimals="false" :examples="[
        'Born 1 June 2026' => ['birth' => '2026-06-01', 'on' => '2026-10-18', 'premature' => false, 'due' => ''],
        'Born 6 weeks early' => ['birth' => '2026-06-01', 'on' => '2026-09-21', 'premature' => true, 'due' => '2026-07-13'],
        'One-year-old' => ['birth' => '2025-10-18', 'on' => '2026-10-18', 'premature' => false, 'due' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'months' => ['label' => 'In months'],
            'days' => ['label' => 'In days'],
            'corrected' => ['label' => 'Corrected age'],
            'early' => ['label' => 'Born early by'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>weeks = days ÷ 7</li>
            <li>corrected age = age − (due date − birth date)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
