<x-calc.page
    title="Superscript Generator - SolveKit"
    description="Free superscript generator: Unicode superscript digits and letters for powers like x²."
    lede="Make superscript text."
    about="Unicode has superscript digits, signs and most letters."
    :calc="['engine' => 'tc-text', 'tool' => 'superscript', 'fields' => ['text'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How do I write x2 with a superscript?', 'answer' => 'ˣ² ⁺ ʸ³ ⁼ ᶻ⁽ⁿ⁺¹⁾.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="x2 + y3 = z(n+1)" rows="3" />

    <x-calc.result label="Superscript text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'x2 + y3 = z(n+1)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Not converted'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
