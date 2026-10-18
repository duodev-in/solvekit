<x-calc.page
    title="Korean Age Calculator - SolveKit"
    description="Free Korean age calculator: traditional Korean age, year age and international age, with how Korea's 2023 age law applies."
    lede="Find your age in the Korean counting systems."
    about="Traditional Korean age (세는 나이) starts at 1 at birth and adds a year every 1 January. Year age (연 나이) is this year minus the birth year. Since 28 June 2023, Korean law uses international age (만 나이), counted from birth as elsewhere, though year age still applies to some laws such as school entry, military service and the age for buying alcohol and tobacco."
    :calc="['engine' => 'ev-time', 'tool' => 'korean_age', 'fields' => ['birth', 'on']]"
    :how-to="[
        ['name' => 'Enter the birth date', 'text' => 'And today\'s date or another.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate my Korean age?', 'answer' => 'This year − birth year + 1.'],
        ['question' => 'Does Korea still use Korean age?', 'answer' => 'Not officially since 28 June 2023; international age is the legal age.'],
        ['question' => 'Why can Korean age be two years more?', 'answer' => 'A baby born on 31 December is 2 in Korean age the next day.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="2000-12-31" type="date" />

    <x-calc.field name="on" label="On date" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Korean age" />

    <x-calc.options :decimals="false" :examples="[
        'Born 31 December 2000' => ['birth' => '2000-12-31', 'on' => '2026-10-18'],
        'Born 1 January 2000' => ['birth' => '2000-01-01', 'on' => '2026-10-18'],
        'Newborn on New Year\'s Day' => ['birth' => '2025-12-31', 'on' => '2026-01-01'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'international' => ['label' => 'International age'],
            'year' => ['label' => 'Year age'],
            'gap' => ['label' => 'Difference'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Korean age = year − birth year + 1</li>
            <li>year age = year − birth year</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
