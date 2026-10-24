<x-calc.page
    title="Letters to Numbers Converter - SolveKit"
    description="Free letters to numbers converter: A = 1 … Z = 26, A = 0 or ASCII codes, with the sum."
    lede="Convert letters to numbers."
    about="Each letter becomes its position in the alphabet, a common puzzle and cipher step."
    :calc="['engine' => 'tc-text', 'tool' => 'letters_numbers', 'fields' => ['text', 'scheme', 'sep'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is “Hello World” as numbers?', 'answer' => '8 5 12 12 15 / 23 15 18 12 4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="Hello World" rows="3" />
        <x-calc.select name="scheme" label="Scheme" :options="['a1' => 'A = 1 … Z = 26', 'a0' => 'A = 0 … Z = 25', 'ascii' => 'ASCII codes']" selected="a1" />
        <x-calc.select name="sep" label="Separator" :options="['space' => 'Space', 'dash' => 'Dash', 'comma' => 'Comma']" selected="space" />
    </div>

    <x-calc.result label="Numbers" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'Hello World', 'scheme' => 'a1', 'sep' => 'space'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Sum of the letter numbers'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
