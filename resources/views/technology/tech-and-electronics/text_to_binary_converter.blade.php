<x-calc.page
    title="Text to Binary Converter - SolveKit"
    description="Free text to binary converter: text as 8-bit binary bytes (UTF-8)."
    lede="Turn text into binary."
    about="Each character becomes one or more bytes, written as eight binary digits."
    :calc="['engine' => 'tc-text', 'tool' => 'text_binary', 'fields' => ['text', 'sep'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is “Hi!” in binary?', 'answer' => '01001000 01101001 00100001.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="Hi!" rows="3" />
        <x-calc.select name="sep" label="Separate bytes with" :options="['space' => 'Spaces', 'none' => 'Nothing']" selected="space" />
    </div>

    <x-calc.result label="Binary" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'Hi!', 'sep' => 'space'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bytes' => ['label' => 'Bytes (UTF-8)'],
            'bits' => ['label' => 'Bits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Per character" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
