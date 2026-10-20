<x-calc.page
    title="Bit Shift Calculator - SolveKit"
    description="Free bit shift calculator: logical and arithmetic shifts and rotates at 4 to 64 bits."
    lede="Shift or rotate bits."
    about="A left shift by n multiplies by 2ⁿ (bits falling off the left are lost); a logical right shift divides by 2ⁿ; an arithmetic right shift keeps the sign bit; rotates move the bits round the end."
    :calc="['engine' => 'mt-bits', 'tool' => 'shift', 'fields' => ['a', 'n', 'kind', 'base', 'bits']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 10110011 shifted left by 2 in 8 bits?', 'answer' => '1100 1100.'],
        ['question' => 'And arithmetic right by 2?', 'answer' => '1110 1100.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Number" value="10110011" type="text" inputmode="text" />
        <x-calc.field name="n" label="Shift by" value="2" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="kind" label="Shift" :options="['left' => 'Left (<<)', 'right' => 'Logical right (>>>)', 'arith' => 'Arithmetic right (>>)', 'rol' => 'Rotate left', 'ror' => 'Rotate right']" selected="left" />
        <x-calc.select name="base" label="Numbers typed in" :options="['bin' => 'Binary', 'dec' => 'Decimal', 'hex' => 'Hexadecimal', 'auto' => 'Auto (0b…, 0x…, else decimal)']" selected="bin" />
        <x-calc.select name="bits" label="Bit width" :options="['4' => '4 bits', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="8" />
    </div>

    <x-calc.result label="Shifted" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '10110011', 'n' => 2, 'kind' => 'left', 'base' => 'bin', 'bits' => '8'],
        'Arith' => ['a' => '10110011', 'n' => 2, 'kind' => 'arith', 'base' => 'bin', 'bits' => '8'],
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
            <li>x << n = x × 2ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
