<x-calc.page
    title="Binary Fraction Converter - SolveKit"
    description="Free binary fraction converter: decimal fractions to binary with the exact repeating block (0.1 = 0.0(0011)₂), and binary fractions back to decimal."
    lede="Convert fractions to binary."
    about="Multiply the fractional part by 2 repeatedly; the integer parts are the bits. Only fractions whose denominator is a power of 2 terminate, so 0.1 = 0.000110011… repeats forever, which is why 0.1 + 0.2 ≠ 0.3 in floating point."
    :calc="['engine' => 'mt-bits', 'tool' => 'fraction', 'fields' => ['dir', 'dec', 'bin']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.1 in binary?', 'answer' => '0.0(0011).'],
        ['question' => 'What is 101.011₂ in decimal?', 'answer' => '5.375.'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Decimal → binary', 'from' => 'Binary → decimal']" selected="to" />

    <div data-show-when="dir:to" hidden>
        <x-calc.field name="dec" label="Decimal number (fractions like 1/3 work)" value="0.1" type="text" inputmode="text" />
    </div>

    <div data-show-when="dir:from" hidden>
        <x-calc.field name="bin" label="Binary number (use brackets for a repeating block)" value="101.011" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Binary" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'dec' => '0.1', 'bin' => '101.011'],
        'Back' => ['dir' => 'from', 'dec' => '0.1', 'bin' => '101.011'],
        'Repeating' => ['dir' => 'from', 'dec' => '0.1', 'bin' => '0.0(0011)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Binary'],
            'exact' => ['label' => 'Exact value'],
            'decimal' => ['label' => 'Decimal'],
            'kind' => ['label' => 'Type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bits from repeated doubling</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
