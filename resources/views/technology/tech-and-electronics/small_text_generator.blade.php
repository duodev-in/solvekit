<x-calc.page
    title="Small Text Generator - SolveKit"
    description="Free small text generator: tiny superscript, subscript or small-caps style text to copy and paste."
    lede="Make small text."
    about="Small text is built from Unicode superscript, subscript or small-capital letters."
    :calc="['engine' => 'tc-text', 'tool' => 'small_text', 'fields' => ['text', 'style'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does the example look like?', 'answer' => 'ˢᵐᵃˡˡ ᵗᵉˣᵗ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="small text" rows="3" />
        <x-calc.select name="style" label="Style" :options="['sup' => 'Superscript-style ˢᵐᵃˡˡ', 'sub' => 'Subscript-style ₛₘₐₗₗ', 'caps' => 'Small caps ꜱᴍᴀʟʟ']" selected="sup" />
    </div>

    <x-calc.result label="Small text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'small text', 'style' => 'sup'],
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
