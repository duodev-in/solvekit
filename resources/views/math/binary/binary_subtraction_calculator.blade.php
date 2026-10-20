<x-calc.page
    title="Binary Subtraction Calculator - SolveKit"
    description="Free binary subtraction calculator: subtract binary numbers with borrows, and see the two's complement view."
    lede="Subtract binary numbers."
    about="Subtract column by column, borrowing 2 from the next column when needed: 10010 − 111 = 1011 (18 − 7 = 11). Computers subtract by adding the two's complement."
    :calc="['engine' => 'mt-bits', 'tool' => 'arith', 'fields' => ['a', 'b', 'base', 'bits'], 'op' => 'sub']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 10010 − 111?', 'answer' => '1011.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="A" value="10010" type="text" inputmode="text" />
        <x-calc.field name="b" label="B" value="111" type="text" inputmode="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="base" label="Numbers typed in" :options="['bin' => 'Binary', 'dec' => 'Decimal', 'hex' => 'Hexadecimal', 'auto' => 'Auto (0b…, 0x…, else decimal)']" selected="bin" />
        <x-calc.select name="bits" label="Width" :options="['none' => 'Unlimited', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="none" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '10010', 'b' => '111', 'base' => 'bin', 'bits' => 'none'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Binary'],
            'decimal' => ['label' => 'Decimal'],
            'hex' => ['label' => 'Hex'],
            'octal' => ['label' => 'Octal'],
            'overflow' => ['label' => 'Overflow'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>borrow when a column goes below 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
