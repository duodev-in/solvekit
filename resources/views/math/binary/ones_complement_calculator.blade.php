<x-calc.page
    title="One's Complement Calculator - SolveKit"
    description="Free one's complement calculator: flip every bit, and the signed one's complement value of a pattern."
    lede="Find the one's complement."
    about="The one's complement flips every bit. As a signed system, −x is NOT x: −5 in 8 bits is 1111 1010. It has two zeros (0000 0000 and 1111 1111) and is still used in the Internet checksum."
    :calc="['engine' => 'mt-bits', 'tool' => 'complement', 'fields' => ['a', 'base', 'bits'], 'kind' => 'ones']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is −5 in 8-bit one\'s complement?', 'answer' => '1111 1010.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Number or pattern" value="-5" type="text" inputmode="text" />
        <x-calc.select name="base" label="I am entering" :options="['dec' => 'A decimal number', 'bin' => 'A binary pattern', 'hex' => 'A hex pattern']" selected="dec" />
        <x-calc.select name="bits" label="Bit width" :options="['4' => '4 bits', '8' => '8 bits', '16' => '16 bits', '32' => '32 bits', '64' => '64 bits']" selected="8" />
    </div>

    <x-calc.result label="One's complement" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '-5', 'base' => 'dec', 'bits' => '8'],
        'Pattern' => ['a' => '11111010', 'base' => 'bin', 'bits' => '8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Pattern'],
            'ones' => ['label' => 'Bits flipped'],
            'twos' => ['label' => 'Two\'s complement'],
            'range' => ['label' => 'Range'],
            'hex' => ['label' => 'Hex'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>−x = NOT x</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
