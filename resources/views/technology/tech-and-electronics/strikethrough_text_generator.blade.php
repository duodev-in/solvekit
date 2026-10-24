<x-calc.page
    title="Strikethrough Text Generator - SolveKit"
    description="Free strikethrough text generator: crossed-out text with combining characters that paste anywhere."
    lede="Make strikethrough text."
    about="A combining overlay after each character draws a line through it."
    :calc="['engine' => 'tc-text', 'tool' => 'strike', 'fields' => ['text', 'style'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does the example look like?', 'answer' => 'c̶r̶o̶s̶s̶e̶d̶ ̶o̶u̶t̶.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="crossed out" rows="3" />
        <x-calc.select name="style" label="Style" :options="['̶' => 'Long stroke s̶t̶r̶i̶k̶e̶', '̵' => 'Short stroke s̵t̵r̵i̵k̵e̵', '̸' => 'Slash s̸t̸r̸i̸k̸e̸', '̲' => 'Underline u̲n̲d̲e̲r̲']" selected="̶" />
    </div>

    <x-calc.result label="Strikethrough text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'crossed out', 'style' => '̶'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'How it works'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
