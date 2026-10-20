<x-calc.page
    title="ISBN Check Digit Calculator - SolveKit"
    description="Free ISBN check digit calculator: validate ISBN-10 and ISBN-13, compute the check digit and convert between them."
    lede="Check an ISBN."
    about="ISBN-10 uses weights 10 down to 2 and a mod 11 check digit (X means 10); ISBN-13 uses alternating weights 1 and 3 with mod 10. Converting adds 978 and recomputes the check digit: 0-306-40615-2 becomes 978-0-306-40615-7."
    :calc="['engine' => 'mt-other', 'tool' => 'isbn', 'fields' => ['isbn']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'Is 978-0-306-40615-7 valid?', 'answer' => 'Valid ISBN-13.'],
        ['question' => 'What check digit completes 0-306-40615?', 'answer' => '2.'],
    ]"
>
    <x-calc.field name="isbn" label="ISBN (with or without the check digit)" value="978-0-306-40615-7" type="text" inputmode="text" />

    <x-calc.result label="ISBN check" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['isbn' => '978-0-306-40615-7'],
        'Ten' => ['isbn' => '0-306-40615'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'check' => ['label' => 'Check digit'],
            'isbn10' => ['label' => 'ISBN-10'],
            'isbn13' => ['label' => 'ISBN-13'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ISO 2108 check digits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
