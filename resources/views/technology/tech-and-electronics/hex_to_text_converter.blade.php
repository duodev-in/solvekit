<x-calc.page
    title="Hex-to-Text Converter - SolveKit"
    description="Free hex to text converter: decode hexadecimal bytes into readable text (UTF-8)."
    lede="Turn hex into text."
    about="Two hexadecimal digits make one byte; the bytes are read as UTF-8 text."
    :calc="['engine' => 'tc-text', 'tool' => 'hex_text', 'fields' => ['hex'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does 48 65 6C 6C 6F say?', 'answer' => 'It starts “Hello”.'],
    ]"
>
    <x-calc.textarea name="hex" label="Hex bytes" value="48 65 6C 6C 6F 20 E2 9C 93" rows="3" />

    <x-calc.result label="Text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hex' => '48 65 6C 6C 6F 20 E2 9C 93'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bytes' => ['label' => 'Bytes'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
