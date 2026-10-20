<x-calc.page
    title="Binary Calculator - SolveKit"
    description="Free binary calculator: add, subtract, multiply and divide binary numbers, with decimal, hex and octal results."
    lede="Calculate in binary."
    about="Type binary numbers (or switch to decimal or hex input). Results are exact at any length; choose a fixed width to see how a CPU register would overflow."
    :calc="['engine' => 'mt-bits', 'tool' => 'arith', 'fields' => ['op', 'a', 'b', 'base', 'bits']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 1011 + 110 in binary?', 'answer' => '10001.'],
    ]"
>
    <x-calc.select name="op" label="Operation" :options="['add' => 'A + B', 'sub' => 'A − B', 'mul' => 'A × B', 'div' => 'A ÷ B', 'mod' => 'A mod B']" selected="add" />

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
        'Example' => ['a' => '1011', 'b' => '110', 'base' => 'bin', 'bits' => 'none', 'op' => 'add'],
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
            <li>carry when a column reaches 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
