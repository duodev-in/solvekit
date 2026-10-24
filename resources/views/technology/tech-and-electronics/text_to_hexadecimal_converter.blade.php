<x-calc.page
    title="Text-to-Hexadecimal Converter - SolveKit"
    description="Free text to hex converter: text as hexadecimal bytes in spaced, plain, 0x or escaped form."
    lede="Turn text into hex."
    about="Each byte of the UTF-8 text becomes two hexadecimal digits."
    :calc="['engine' => 'tc-text', 'tool' => 'text_hex', 'fields' => ['text', 'style'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is “Hello ✓” in hex?', 'answer' => '48 65 6C 6C 6F 20 E2 9C 93.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="Hello ✓" rows="3" />
        <x-calc.select name="style" label="Format" :options="['space' => 'Spaced (48 65 6C)', 'plain' => 'Plain (48656C)', 'prefix' => '0x prefix (0x48, 0x65)', 'escape' => 'Escaped (\\x48\\x65)']" selected="space" />
    </div>

    <x-calc.result label="Hexadecimal" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'Hello ✓', 'style' => 'space'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bytes' => ['label' => 'Bytes (UTF-8)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Per character" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
