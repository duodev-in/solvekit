<x-calc.page
    title="Decimal to Hexadecimal Converter - SolveKit"
    description="Professional decimal and hexadecimal converter for programming and digital systems. Convert in both directions with complete base outputs and readable steps."
    lede="Convert decimal to hexadecimal, or hexadecimal to decimal."
    about="To write a decimal number in hex, divide by 16 repeatedly; each remainder (0 to 15, written 0–9 and A–F) is a hex digit, read from last to first. To read hex, multiply each digit by its power of 16 and add."
    :calc="['engine' => 'radix']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Decimal to hexadecimal, or the reverse.'],
        ['name' => 'Type the number', 'text' => 'Whole numbers of any length. Spaces and underscores are ignored.'],
        ['name' => 'Read every base', 'text' => 'Binary, octal, decimal and hexadecimal are all listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert decimal to hex?', 'answer' => 'Divide by 16 and keep the remainders: 255 ÷ 16 = 15 r 15, so 255 = FF.'],
        ['question' => 'How do I convert hex to decimal?', 'answer' => 'Multiply each digit by its power of 16: 1A = 1×16 + 10 = 26.'],
        ['question' => 'What do 0x and # mean before hex numbers?', 'answer' => 'They are just prefixes that mark a number as hexadecimal; the value is the same.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['10:16' => 'Decimal → Hexadecimal', '16:10' => 'Hexadecimal → Decimal']" selected="10:16" />

    <x-calc.field name="value" type="text" label="Decimal number" label-ref="value-label" value="48879" placeholder="Enter a number" spellcheck="false" autocapitalize="off" />

    <x-calc.result label="Hexadecimal" />

    <x-calc.options :decimals="false" :examples="[
        '255' => ['value' => '255', 'direction' => '10:16'],
        'Colour 1E90FF' => ['value' => '1E90FF', 'direction' => '16:10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="In every base" :rows="[
            'bin' => ['label' => 'Binary (base 2)'],
            'oct' => ['label' => 'Octal (base 8)'],
            'dec' => ['label' => 'Decimal (base 10)'],
            'hex' => ['label' => 'Hexadecimal (base 16)'],
            'bits' => ['label' => 'Bit length'],
            'bytes' => ['label' => 'Bytes needed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hex: divide by 16, keep remainders</li>
            <li>decimal = Σ digit × 16^position</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
