<x-calc.page
    title="IEEE 754 Floating Point Converter - SolveKit"
    description="Free IEEE 754 converter: sign, exponent and mantissa of a number in half (16), single (32) and double (64) precision, with the exact stored value and rounding error."
    lede="See how a number is stored as a float."
    about="A float stores a sign, a biased exponent and the fraction bits of a binary number 1.xxx × 2^e. 0.1 cannot be stored exactly: as a 32-bit float it is 0x3DCCCCCD, exactly 0.100000001490116119384765625. Also known as floating point converter and float to binary converter."
    :calc="['engine' => 'mt-bits', 'tool' => 'ieee', 'fields' => ['dir', 'x', 'pattern', 'bits']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'How is 0.1 stored as a 32-bit float?', 'answer' => '0x3DCCCCCD, exactly 0.100000001490116119384765625.'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Decimal → bits', 'from' => 'Bits → decimal']" selected="to" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="x" label="Decimal number" value="0.1" type="text" inputmode="text" />
        </div>
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="pattern" label="Bits or 0x hex" value="0x3FF0000000000000" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.select name="bits" label="Precision" :options="['16' => 'Half (16-bit)', '32' => 'Single (32-bit)', '64' => 'Double (64-bit)']" selected="32" />

    <x-calc.result label="Bit pattern" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'x' => '0.1', 'pattern' => '0x3FF0000000000000', 'bits' => '32'],
        'Double' => ['dir' => 'from', 'x' => '0.1', 'pattern' => '0x3FF0000000000000', 'bits' => '64'],
        'Half' => ['dir' => 'to', 'x' => '-2.5', 'pattern' => '0x3FF0000000000000', 'bits' => '16'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'hex' => ['label' => 'Hex'],
            'sign' => ['label' => 'Sign'],
            'exponent' => ['label' => 'Exponent'],
            'mantissa' => ['label' => 'Mantissa'],
            'stored' => ['label' => 'Exact stored value'],
            'error' => ['label' => 'Rounding error'],
            'kind' => ['label' => 'Kind'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(−1)ˢ × 1.m × 2^(e − bias)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
