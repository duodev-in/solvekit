<x-calc.page
    title="Underline Text Generator - SolveKit"
    description="Free underline text generator: underlined, double-underlined, strikethrough, slashed and overlined text to copy and paste anywhere."
    lede="Make underlined or crossed-out text to paste anywhere."
    about="A combining mark is added after each character: U+0332 underline, U+0333 double underline, U+0336 strikethrough, U+0338 slash and U+0305 overline. They are special Unicode letters, not a font, so they paste into social media bios, posts and messages. Some apps, screen readers and search engines do not read them as normal letters, so avoid them for important text."
    :calc="['engine' => 'ev-fun', 'tool' => 'underline', 'fields' => ['text', 'style']]"
    :how-to="[
        ['name' => 'Type or paste your text', 'text' => 'It converts as you type.'],
        ['name' => 'Copy the result', 'text' => 'With the Copy button.'],
    ]"
    :faqs="[
        ['question' => 'How do I underline text on social media?', 'answer' => 'Convert it here and paste it.'],
        ['question' => 'How do I cross out text?', 'answer' => 'Choose Strikethrough.'],
        ['question' => 'Why do gaps appear between letters?', 'answer' => 'Some fonts draw combining marks less smoothly.'],
    ]"
>
    <x-calc.textarea name="text" label="Your text" value="Underline this line" rows="3" />

    <x-calc.select name="style" label="Style" :options="['underline' => 'Underline', 'double' => 'Double underline', 'strike' => 'Strikethrough', 'slash' => 'Slashed', 'overline' => 'Overline']" selected="underline" />

    <x-calc.result label="Converted text" />

    <x-calc.options :decimals="false" :examples="[
        'Underline' => ['text' => 'Underline this line', 'style' => 'underline'],
        'Strikethrough' => ['text' => 'Old price $49', 'style' => 'strike'],
        'Double' => ['text' => 'Important', 'style' => 'double'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="All styles" name="variants" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>each character + U+0332 (underline)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
