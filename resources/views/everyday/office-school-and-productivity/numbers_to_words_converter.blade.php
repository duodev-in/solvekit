<x-calc.page
    title="Numbers to Words Converter - SolveKit"
    description="Free numbers to words converter: write any number in English words, in the US short scale or the Indian lakh and crore system, with ordinals and check wording."
    lede="Write any number out in words."
    about="Numbers are written in groups of three digits with thousand, million, billion and so on (the short scale, used in English today). In the Indian system, 1,00,000 is one lakh and 1,00,00,000 one crore. Decimals are read digit by digit after point. Hyphens join tens and units from twenty-one to ninety-nine."
    :calc="['engine' => 'ev-office', 'tool' => 'numbers_words', 'fields' => ['number', 'system']]"
    :how-to="[
        ['name' => 'Enter a number', 'text' => 'With or without commas.'],
        ['name' => 'Pick the system', 'text' => 'International or Indian.'],
    ]"
    :faqs="[
        ['question' => 'How do you write 1,234,567 in words?', 'answer' => 'One million two hundred thirty-four thousand five hundred sixty-seven.'],
        ['question' => 'What is 1 crore in millions?', 'answer' => '10 million.'],
        ['question' => 'How is 0.5 written?', 'answer' => 'Zero point five.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="number" label="Number" value="1234567.89" type="text" placeholder="1234567.89" />
        <x-calc.segmented name="system" legend="System" :options="['western' => 'Million, billion', 'indian' => 'Lakh, crore']" selected="western" />
    </div>

    <x-calc.result label="In words" />

    <x-calc.options :decimals="false" :examples="[
        '1,234,567.89' => ['number' => '1234567.89', 'system' => 'western'],
        '1,23,45,678 (Indian)' => ['number' => '12345678', 'system' => 'indian'],
        '21st' => ['number' => '21', 'system' => 'western'],
        'Negative decimal' => ['number' => '-42.05', 'system' => 'western'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ordinal' => ['label' => 'Ordinal'],
            'other' => ['label' => 'Other system'],
            'check' => ['label' => 'Check wording'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>groups of three digits: thousand, million, billion…</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
