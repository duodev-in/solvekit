<x-calc.page
    title="Subscript Generator - SolveKit"
    description="Free subscript generator: Unicode subscript digits and letters for formulas like H₂O."
    lede="Make subscript text."
    about="Unicode has subscript digits, signs and some lowercase letters."
    :calc="['engine' => 'tc-text', 'tool' => 'subscript', 'fields' => ['text'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How do I write H2O with a subscript?', 'answer' => 'H₂O ₊ CO₂ → H₂CO₃.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="H2O + CO2 → H2CO3" rows="3" />

    <x-calc.result label="Subscript text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'H2O + CO2 → H2CO3'],
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
