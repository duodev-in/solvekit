<x-calc.page
    title="Gray Code Converter - SolveKit"
    description="Free Gray code converter: binary to reflected Gray code and back, where consecutive values differ in one bit."
    lede="Convert to and from Gray code."
    about="In Gray code neighbouring numbers differ in exactly one bit, so rotary encoders never misread during a change. Gray = n XOR (n >> 1); converting back XORs all the higher bits. Also known as reflected binary code converter."
    :calc="['engine' => 'mt-bits', 'tool' => 'gray', 'fields' => ['dir', 'a', 'base']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Choose how you type them: binary, decimal or hex (auto also accepts 0b… and 0x… prefixes).'],
        ['name' => 'Pick the width', 'text' => 'Results are shown aligned bit by bit with decimal and hex.'],
    ]"
    :faqs="[
        ['question' => 'What is 13 in Gray code?', 'answer' => '1011.'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Number → Gray code', 'from' => 'Gray code → binary']" selected="to" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Value" value="13" type="text" inputmode="text" />
        <div data-show-when="dir:to" hidden>
            <x-calc.select name="base" label="Typed in" :options="['dec' => 'Decimal', 'bin' => 'Binary', 'hex' => 'Hex']" selected="dec" />
        </div>
    </div>

    <x-calc.result label="Gray code" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'a' => '13', 'base' => 'dec'],
        'Back' => ['dir' => 'from', 'a' => '1011', 'base' => 'dec'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Binary'],
            'gray' => ['label' => 'Gray code'],
            'decimal' => ['label' => 'Decimal'],
            'next' => ['label' => 'Next value'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>g = n ⊕ (n >> 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
