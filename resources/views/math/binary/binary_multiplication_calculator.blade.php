<x-calc.page
    title="Binary Multiplication Calculator - SolveKit"
    description="Free binary multiplication calculator: shift-and-add long multiplication of binary numbers."
    lede="Multiply binary numbers."
    about="Each 1 in the multiplier copies the multiplicand, shifted; add the copies. 1011 × 110 = 1000010 (11 × 6 = 66)."
    :calc="['engine' => 'mt-bits', 'tool' => 'arith', 'fields' => ['a', 'b', 'base', 'bits'], 'op' => 'mul']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 1011 × 110?', 'answer' => '1000010.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="A" value="1011" type="text" inputmode="text" />
        <x-calc.field name="b" label="B" value="110" type="text" inputmode="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="base" label="Numbers typed in" :options="['bin' => 'Binary', 'dec' => 'Decimal', 'hex' => 'Hexadecimal', 'auto' => 'Auto (0b…, 0x…, else decimal)']" selected="bin" />
        <x-calc.select name="bits" label="Width" :options="['none' => 'Unlimited', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="none" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1011', 'b' => '110', 'base' => 'bin', 'bits' => 'none'],
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
            <li>shift and add</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
