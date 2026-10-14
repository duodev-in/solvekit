<x-calc.page
    title="Roman Numerals Converter - SolveKit"
    description="Professional Roman numerals converter for historical and educational purposes. Convert between Roman numerals and decimal numbers with detailed rules and explanations."
    lede="Convert numbers to Roman numerals, or Roman numerals to numbers."
    about="Roman numerals add symbol values from largest to smallest (I 1, V 5, X 10, L 50, C 100, D 500, M 1000). A smaller symbol before a larger one is subtracted, but only in six pairs: IV, IX, XL, XC, CD and CM. Standard numerals run from 1 to 3999."
    :calc="['engine' => 'roman']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Number to Roman numeral, or Roman numeral to number.'],
        ['name' => 'Type the value', 'text' => 'Invalid numerals such as IIII or VX are rejected with an explanation.'],
    ]"
    :faqs="[
        ['question' => 'How do you write 2026 in Roman numerals?', 'answer' => 'MMXXVI: M + M + X + X + V + I.'],
        ['question' => 'Why is 4 written IV and not IIII?', 'answer' => 'Standard notation subtracts I before V. IIII appears on some clock faces but is not standard.'],
        ['question' => 'What is the largest Roman numeral?', 'answer' => 'MMMCMXCIX (3999) in standard notation. Larger numbers used an overline to multiply by 1,000.'],
        ['question' => 'Is there a Roman numeral for zero?', 'answer' => 'No. The Roman system had no symbol for zero.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['number' => 'Number → Roman', 'roman' => 'Roman → Number']" selected="number" />

    <x-calc.field name="value" type="text" label="Number (1 to 3999)" label-ref="value-label" value="2026" placeholder="Enter a value" spellcheck="false" autocapitalize="characters" />

    <x-calc.result label="Roman numeral" />

    <x-calc.options :decimals="false" :examples="[
        'Year 1999' => ['value' => '1999', 'direction' => 'number'],
        'Super Bowl LVIII' => ['value' => 'LVIII', 'direction' => 'roman'],
        'Chapter XIV' => ['value' => 'XIV', 'direction' => 'roman'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'number' => ['label' => 'Number'],
            'numeral' => ['label' => 'Roman numeral'],
            'symbols' => ['label' => 'Symbols used'],
            'length' => ['label' => 'Length'],
        ]" />
        <x-calc.steps heading="Symbol by symbol" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="grid grid-cols-2 gap-x-6 gap-y-1 font-mono text-[13px]">
            <li>I = 1 · V = 5</li>
            <li>X = 10 · L = 50</li>
            <li>C = 100 · D = 500</li>
            <li>M = 1,000</li>
            <li>IV 4 · IX 9 · XL 40</li>
            <li>XC 90 · CD 400 · CM 900</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
