<x-calc.page
    title="Lunar Age Calculator - SolveKit"
    description="Free lunar age calculator: Chinese nominal (lunar) age, which starts at 1 and adds a year each Chinese New Year, with your Chinese zodiac animal and element."
    lede="Work out your Chinese lunar age and zodiac sign."
    about="In traditional Chinese counting (虚岁) you are 1 at birth and a year older at each Chinese New Year, so lunar age is one or two years above international age. Your zodiac animal and element come from the Chinese year you were born in, which starts at Chinese New Year, not 1 January. New Year dates for 1900–2099 come from the Hong Kong Observatory based tables, each checked against the astronomical new moon."
    :calc="['engine' => 'ev-time', 'tool' => 'lunar_age', 'fields' => ['birth', 'on'], 'data' => ['chinese_new_year' => config('everyday_data.chinese_new_year')]]"
    :how-to="[
        ['name' => 'Enter the birth date', 'text' => 'See the lunar age and animal.'],
    ]"
    :faqs="[
        ['question' => 'What is my Chinese zodiac if I was born in January?', 'answer' => 'You may belong to the previous year\'s animal: someone born on 20 January 1990 is a Snake, because the Year of the Horse began on 27 January.'],
        ['question' => 'How is lunar age counted?', 'answer' => '1 at birth, plus 1 at each Chinese New Year.'],
        ['question' => 'What year is 2026?', 'answer' => 'The Year of the Fire Horse, from 17 February 2026.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="1990-01-20" type="date" />

    <x-calc.field name="on" label="On date" value="{{ now()->toDateString() }}" type="date" />

    <x-calc.result label="Lunar age" />

    <x-calc.options :decimals="false" :examples="[
        'Born 20 Jan 1990' => ['birth' => '1990-01-20', 'on' => '2026-10-18'],
        'Born 1 Mar 1990' => ['birth' => '1990-03-01', 'on' => '2026-10-18'],
        'Baby born 2026' => ['birth' => '2026-02-20', 'on' => '2026-10-18'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'zodiac' => ['label' => 'Zodiac sign'],
            'international' => ['label' => 'International age'],
            'year' => ['label' => 'Current year'],
            'next' => ['label' => 'Next New Year'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lunar age = Chinese year now − Chinese year of birth + 1</li>
            <li>animal = (year − 4) mod 12, Rat = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
