<x-calc.page
    title="Bitwise Calculator - SolveKit"
    description="Free bitwise calculator: AND, OR, XOR, NAND, NOR, XNOR and NOT on binary, decimal or hex numbers."
    lede="Compute a bitwise operation bit by bit."
    about="Bitwise operators work on each bit position separately. Choose the operation and the width; negative decimals are taken as two's complement patterns."
    :calc="['engine' => 'mt-bits', 'tool' => 'logic', 'fields' => ['op', 'a', 'b', 'base', 'bits']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is NOT 0xF0 in 8 bits?', 'answer' => '0x0F.'],
    ]"
>
    <x-calc.select name="op" label="Operation" :options="['and' => 'AND', 'or' => 'OR', 'xor' => 'XOR', 'nand' => 'NAND', 'nor' => 'NOR', 'xnor' => 'XNOR', 'not' => 'NOT A']" selected="and" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="A" value="1100" type="text" inputmode="text" />
        <div data-show-when="op:and,or,xor,nand,nor,xnor" hidden>
            <x-calc.field name="b" label="B" value="1010" type="text" inputmode="text" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="base" label="Numbers typed in" :options="['bin' => 'Binary', 'dec' => 'Decimal', 'hex' => 'Hexadecimal', 'auto' => 'Auto (0b…, 0x…, else decimal)']" selected="bin" />
        <x-calc.select name="bits" label="Bit width" :options="['4' => '4 bits', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="8" />
    </div>

    <x-calc.result label="A AND B" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1100', 'b' => '1010', 'base' => 'bin', 'bits' => '8', 'op' => 'and'],
        'Decimal' => ['a' => '200', 'b' => '77', 'base' => 'dec', 'bits' => '8', 'op' => 'and'],
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
            <li>AND per bit</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
