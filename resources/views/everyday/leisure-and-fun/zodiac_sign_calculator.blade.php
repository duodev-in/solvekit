<x-calc.page
    title="Zodiac Sign Calculator - SolveKit"
    description="Free zodiac sign calculator: your Western (sun) sign and Chinese zodiac animal and element from your date of birth."
    lede="Find your star sign and Chinese zodiac animal."
    about="Western sun signs follow the usual date ranges (Aries 21 March – 19 April and so on); the sun's exact entry into each sign shifts by about a day between years, so people born on a cusp may see either sign. The Chinese year starts at Chinese New Year, not 1 January, so January and early February birthdays may belong to the previous year's animal. For entertainment only."
    :calc="['engine' => 'ev-fun', 'tool' => 'zodiac', 'fields' => ['birth'], 'data' => ['chinese_new_year' => config('everyday_data.chinese_new_year')]]"
    :how-to="[
        ['name' => 'Enter your birth date', 'text' => 'See both signs.'],
    ]"
    :faqs="[
        ['question' => 'What sign is 24 August?', 'answer' => 'Virgo (23 August – 22 September).'],
        ['question' => 'What Chinese animal is 1995?', 'answer' => 'Wood Pig, from 31 January 1995.'],
        ['question' => 'Why is my Chinese animal not my birth year\'s?', 'answer' => 'Births before Chinese New Year belong to the previous year.'],
    ]"
>
    <x-calc.field name="birth" label="Date of birth" value="1995-08-24" type="date" />

    <x-calc.result label="Western zodiac sign" />

    <x-calc.options :decimals="false" :examples="[
        '24 August 1995' => ['birth' => '1995-08-24'],
        'Born 25 January 1990' => ['birth' => '1990-01-25'],
        'Leap day 2000' => ['birth' => '2000-02-29'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'chinese' => ['label' => 'Chinese zodiac'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sign from date ranges; animal = (Chinese year − 4) mod 12</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
