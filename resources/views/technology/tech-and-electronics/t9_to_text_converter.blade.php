<x-calc.page
    title="T9 to Text Converter - SolveKit"
    description="Free T9 to text converter: decode phone keypad multi-tap presses into text, or text into key presses."
    lede="Decode keypad presses."
    about="On old phone keypads each number holds three or four letters; pressing it several times picks the letter."
    :calc="['engine' => 'tc-text', 'tool' => 't9', 'fields' => ['mode', 'keys', 'text'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What do 44 33 555 555 666 spell?', 'answer' => 'They start HELLO WORLD.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Convert" :options="['toText' => 'Key presses → text', 'toKeys' => 'Text → key presses']" selected="toText" />
        <x-calc.textarea name="keys" label="Key presses (multi-tap groups separated by spaces, 0 = space)" value="44 33 555 555 666 0 9 666 777 555 3" rows="3" />
        <x-calc.textarea name="text" label="Text" value="Hello world" rows="3" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'toText', 'keys' => '44 33 555 555 666 0 9 666 777 555 3', 'text' => 'Hello world'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'presses' => ['label' => 'Key presses'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
