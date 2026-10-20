<x-calc.page
    title="NOR Calculator - SolveKit"
    description="Free NOR calculator: bitwise NOT OR of two numbers at a chosen width."
    lede="Compute NOR bit by bit."
    about="NOR is OR followed by NOT: 1 only where both bits are 0. Like NAND it is universal: any logic circuit can be built from NOR gates alone."
    :calc="['engine' => 'mt-bits', 'tool' => 'logic', 'fields' => ['a', 'b', 'base', 'bits'], 'op' => 'nor']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 1100 NOR 1010 in 8 bits?', 'answer' => '1111 0001.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="A" value="1100" type="text" inputmode="text" />
        <x-calc.field name="b" label="B" value="1010" type="text" inputmode="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="base" label="Numbers typed in" :options="['bin' => 'Binary', 'dec' => 'Decimal', 'hex' => 'Hexadecimal', 'auto' => 'Auto (0b…, 0x…, else decimal)']" selected="bin" />
        <x-calc.select name="bits" label="Bit width" :options="['4' => '4 bits', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="8" />
    </div>

    <x-calc.result label="A NOR B" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1100', 'b' => '1010', 'base' => 'bin', 'bits' => '8'],
        'Decimal' => ['a' => '200', 'b' => '77', 'base' => 'dec', 'bits' => '8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Binary'],
            'decimal' => ['label' => 'Unsigned'],
            'signed' => ['label' => 'Signed (two\'s complement)'],
            'hex' => ['label' => 'Hex'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NOR per bit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
