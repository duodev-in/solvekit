<x-calc.page
    title="Binary to Octal Converter - SolveKit"
    description="Professional binary and octal converter for computer science and digital systems. Convert both ways with complete base outputs and transparent calculation steps."
    lede="Convert binary to octal, or octal to binary."
    about="One octal digit stands for exactly three binary digits, so binary is split into groups of three from the right and each group becomes one octal digit (000 = 0 … 111 = 7)."
    :calc="['engine' => 'radix']"
    :how-to="[
        ['name' => 'Choose a direction', 'text' => 'Binary to octal, or the reverse.'],
        ['name' => 'Type the number', 'text' => 'Whole numbers of any length. Spaces and underscores are ignored.'],
        ['name' => 'Read the working', 'text' => 'Every base is listed, with the steps of the conversion below.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert binary to octal?', 'answer' => 'Group the bits in threes from the right: 110 101 011 = 653.'],
        ['question' => 'Where is octal still used?', 'answer' => 'Mainly for Unix file permissions, such as 755 or 644.'],
        ['question' => 'How do I convert octal to binary?', 'answer' => 'Replace each octal digit with its three bits: 7 = 111, 5 = 101.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Direction" :options="['2:8' => 'Binary → Octal', '8:2' => 'Octal → Binary']" selected="2:8" />

    <x-calc.field name="value" type="text" label="Binary number" label-ref="value-label" value="110101011" placeholder="Enter a number" spellcheck="false" autocapitalize="off" />

    <x-calc.result label="Octal" />

    <x-calc.options :decimals="false" :examples="[
        'Permissions 111101101' => ['value' => '111101101', 'direction' => '2:8'],
        'chmod 644' => ['value' => '644', 'direction' => '8:2'],
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
        <x-calc.steps />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 octal digit = 3 bits</li>
            <li>000 = 0 … 111 = 7</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
