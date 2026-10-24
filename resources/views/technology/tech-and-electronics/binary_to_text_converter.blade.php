<x-calc.page
    title="Binary to Text Converter - SolveKit"
    description="Free binary to text converter: decode 8-bit binary bytes into readable text (UTF-8)."
    lede="Turn binary into text."
    about="Each group of eight bits is one byte; bytes are read as UTF-8 text, the same as ASCII for ordinary letters."
    :calc="['engine' => 'tc-text', 'tool' => 'binary_text', 'fields' => ['bits'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does 01001000 01101001 00100001 say?', 'answer' => 'Hi!.'],
    ]"
>
    <x-calc.textarea name="bits" label="Binary (groups of 8 bits)" value="01001000 01101001 00100001" rows="3" />

    <x-calc.result label="Text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bits' => '01001000 01101001 00100001'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bytes' => ['label' => 'Bytes'],
            'encoding' => ['label' => 'Encoding'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
