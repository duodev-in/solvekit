<x-calc.page
    title="Mirror Text Generator - SolveKit"
    description="Free mirror text generator: reverse text and swap in mirrored look-alike characters."
    lede="Make mirror text."
    about="Mirror text reverses the order and swaps letters with their mirrored Unicode look-alikes."
    :calc="['engine' => 'tc-text', 'tool' => 'mirror', 'fields' => ['text'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does the example look like?', 'answer' => '(p ,q ,b ,d) txɘt rorriM.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="Mirror text (b, d, p, q)" rows="3" />

    <x-calc.result label="Mirrored text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'Mirror text (b, d, p, q)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'reversed' => ['label' => 'Just reversed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
