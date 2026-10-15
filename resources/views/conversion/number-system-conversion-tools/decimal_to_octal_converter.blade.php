<x-calc.page
    title="Decimal to Octal Converter - SolveKit"
    description="Professional decimal and octal converter for computer science and system calculations. Convert both ways with complete base outputs and readable step logic."
    lede="Convert decimal to octal, or octal to decimal."
    about="To write a decimal number in octal, divide by 8 repeatedly and read the remainders from last to first. To read octal, multiply each digit by its power of 8 and add."
    :calc="['engine' => 'radix']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Decimal to octal, or the reverse.'],
        ['name' => 'Type the number', 'text' => 'Whole numbers of any length. Spaces and underscores are ignored.'],
        ['name' => 'Read every base', 'text' => 'Binary, octal, decimal and hexadecimal are all listed beside the result.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert decimal to octal?', 'answer' => 'Divide by 8 and keep the remainders: 64 = 100 in octal.'],
        ['question' => 'How do I convert octal to decimal?', 'answer' => 'Multiply each digit by its power of 8: 755 = 7×64 + 5×8 + 5 = 493.'],
        ['question' => 'Which digits does octal use?', 'answer' => 'Only 0 to 7.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['10:8' => 'Decimal → Octal', '8:10' => 'Octal → Decimal']" selected="10:8" />

    <x-calc.field name="value" type="text" label="Decimal number" label-ref="value-label" value="493" placeholder="Enter a number" spellcheck="false" autocapitalize="off" />

    <x-calc.result label="Octal" />

    <x-calc.options :decimals="false" :examples="[
        '64' => ['value' => '64', 'direction' => '10:8'],
        'chmod 755' => ['value' => '755', 'direction' => '8:10'],
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
            <li>octal: divide by 8, keep remainders</li>
            <li>decimal = Σ digit × 8^position</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
