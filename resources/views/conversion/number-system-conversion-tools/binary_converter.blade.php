<x-calc.page
    title="Binary Converter - SolveKit"
    description="Professional binary converter for computer science and programming. Convert between binary and decimal with complete base outputs and clear conversion steps."
    lede="Convert binary to decimal, or decimal to binary, with the working shown."
    about="Each binary digit is a power of two. To read binary, add the powers of two where there is a 1. To write a decimal number in binary, divide by 2 repeatedly and read the remainders from last to first. Numbers of any length are handled exactly."
    :calc="['engine' => 'radix']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Binary to decimal, or the reverse.'],
        ['name' => 'Type the number', 'text' => 'Whole numbers of any length. Spaces and underscores are ignored.'],
        ['name' => 'Read every base', 'text' => 'Binary, octal, decimal and hexadecimal are all listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert binary to decimal?', 'answer' => 'Multiply each digit by its power of two and add them: 1011 = 8 + 0 + 2 + 1 = 11.'],
        ['question' => 'How do I convert decimal to binary?', 'answer' => 'Divide by 2 repeatedly and write the remainders from the last to the first: 13 → 1101.'],
        ['question' => 'Is there a size limit?', 'answer' => 'No. The calculator uses arbitrary-precision integers, so very long binary numbers convert exactly.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['2:10' => 'Binary → Decimal', '10:2' => 'Decimal → Binary']" selected="2:10" />

    <x-calc.field name="value" type="text" label="Binary number" label-ref="value-label" value="101101" placeholder="Enter a number" spellcheck="false" autocapitalize="off" />

    <x-calc.result label="Decimal" />

    <x-calc.options :decimals="false" :examples="[
        'Byte 11111111' => ['value' => '11111111', 'direction' => '2:10'],
        'Year 2026' => ['value' => '2026', 'direction' => '10:2'],
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
            <li>decimal = Σ digit × 2^position</li>
            <li>binary: divide by 2, keep remainders</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
