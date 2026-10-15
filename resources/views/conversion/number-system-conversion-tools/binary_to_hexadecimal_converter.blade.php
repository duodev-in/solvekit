<x-calc.page
    title="Binary to Hexadecimal Converter - SolveKit"
    description="Professional binary and hexadecimal converter for programming and digital systems. Convert both ways with base-wide outputs and clear step breakdown."
    lede="Convert binary to hexadecimal, or hexadecimal to binary."
    about="One hexadecimal digit stands for exactly four binary digits, so binary is split into groups of four from the right and each group becomes one hex digit (0000 = 0 … 1111 = F)."
    :calc="['engine' => 'radix']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Binary to hexadecimal, or the reverse.'],
        ['name' => 'Type the number', 'text' => 'Whole numbers of any length. Spaces and underscores are ignored.'],
        ['name' => 'Read every base', 'text' => 'Binary, octal, decimal and hexadecimal are all listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert binary to hex?', 'answer' => 'Group the bits in fours from the right and replace each group: 1010 1111 = AF.'],
        ['question' => 'Why is hex used with binary?', 'answer' => 'It is a compact way to write binary: two hex digits make one byte.'],
        ['question' => 'How do I convert hex to binary?', 'answer' => 'Replace each hex digit with its four bits: 3C = 0011 1100.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['2:16' => 'Binary → Hexadecimal', '16:2' => 'Hexadecimal → Binary']" selected="2:16" />

    <x-calc.field name="value" type="text" label="Binary number" label-ref="value-label" value="11011110101011011011111011101111" placeholder="Enter a number" spellcheck="false" autocapitalize="off" />

    <x-calc.result label="Hexadecimal" />

    <x-calc.options :decimals="false" :examples="[
        'Byte 10101111' => ['value' => '10101111', 'direction' => '2:16'],
        'Colour FF8800' => ['value' => 'FF8800', 'direction' => '16:2'],
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
            <li>1 hex digit = 4 bits</li>
            <li>0000 = 0 … 1001 = 9, 1010 = A … 1111 = F</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
