<x-calc.page
    title="Two's Complement Calculator - SolveKit"
    description="Free two's complement calculator: the bit pattern of a negative number, or the value of a pattern, at 4 to 64 bits."
    lede="Convert to and from two's complement."
    about="Two's complement stores −x as the bits of x flipped plus 1, so −5 in 8 bits is 1111 1011. The leading bit is worth −2ⁿ⁻¹, giving the range −128 to 127 in 8 bits, and addition needs no special sign handling."
    :calc="['engine' => 'mt-bits', 'tool' => 'complement', 'fields' => ['a', 'base', 'bits'], 'kind' => 'twos']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is −5 in 8-bit two\'s complement?', 'answer' => '1111 1011.'],
        ['question' => 'What value is the pattern 1111 1011?', 'answer' => '−5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Number or pattern" value="-5" type="text" inputmode="text" />
        <x-calc.select name="base" label="I am entering" :options="['dec' => 'A decimal number', 'bin' => 'A binary pattern', 'hex' => 'A hex pattern']" selected="dec" />
        <x-calc.select name="bits" label="Bit width" :options="['4' => '4 bits', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="8" />
    </div>

    <x-calc.result label="Two's complement" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '-5', 'base' => 'dec', 'bits' => '8'],
        'Pattern' => ['a' => '11111011', 'base' => 'bin', 'bits' => '8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Pattern'],
            'ones' => ['label' => 'Bits flipped'],
            'twos' => ['label' => 'Negated'],
            'range' => ['label' => 'Range'],
            'hex' => ['label' => 'Hex'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>−x = NOT x + 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
