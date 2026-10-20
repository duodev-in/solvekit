<x-calc.page
    title="Binary Division Calculator - SolveKit"
    description="Free binary division calculator: long division of binary numbers with quotient and remainder."
    lede="Divide binary numbers."
    about="Binary long division compares, subtracts and brings down bits just like decimal, but each quotient bit is 0 or 1. 110101 ÷ 101 = 1010 remainder 11 (53 ÷ 5 = 10 r 3)."
    :calc="['engine' => 'mt-bits', 'tool' => 'arith', 'fields' => ['a', 'b', 'base', 'bits'], 'op' => 'div']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 110101 ÷ 101?', 'answer' => '1010 r 11.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="A" value="110101" type="text" inputmode="text" />
        <x-calc.field name="b" label="B" value="101" type="text" inputmode="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="base" label="Numbers typed in" :options="['bin' => 'Binary', 'dec' => 'Decimal', 'hex' => 'Hexadecimal', 'auto' => 'Auto (0b…, 0x…, else decimal)']" selected="bin" />
        <x-calc.select name="bits" label="Width" :options="['none' => 'Unlimited', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="none" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '110101', 'b' => '101', 'base' => 'bin', 'bits' => 'none'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Binary'],
            'decimal' => ['label' => 'Decimal'],
            'hex' => ['label' => 'Hex'],
            'octal' => ['label' => 'Octal'],
            'overflow' => ['label' => 'Overflow'],
            'remainder' => ['label' => 'Remainder'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>long division</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
