<x-calc.page
    title="Cursive Font Generator - SolveKit"
    description="Free cursive font generator: turn text into script (cursive) Unicode letters to copy and paste into social media and messages."
    lede="Make cursive text to copy and paste."
    about="Letters are swapped for Unicode Mathematical Script characters (U+1D49C onward); some, such as ℬ, ℰ and ℯ, live in the older Letterlike Symbols block. They are special Unicode letters, not a font, so they paste into social media bios, posts and messages. Some apps, screen readers and search engines do not read them as normal letters, so avoid them for important text."
    :calc="['engine' => 'ev-fun', 'tool' => 'cursive', 'fields' => ['text', 'style']]"
    :how-to="[
        ['name' => 'Type or paste your text', 'text' => 'It converts as you type.'],
        ['name' => 'Copy the result', 'text' => 'With the Copy button.'],
    ]"
    :faqs="[
        ['question' => 'How do I get a cursive font on Instagram?', 'answer' => 'Convert your text here and paste it.'],
        ['question' => 'Why are some letters different sizes?', 'answer' => 'A few script letters come from an older Unicode block and may look slightly different.'],
        ['question' => 'Can I use it for a logo?', 'answer' => 'Use a real font for print; these are characters, not a typeface.'],
    ]"
>
    <x-calc.textarea name="text" label="Your text" value="Happy birthday, Emma" rows="3" />

    <x-calc.select name="style" label="Style" :options="['script' => 'Script', 'bold_script' => 'Bold script']" selected="script" />

    <x-calc.result label="Converted text" />

    <x-calc.options :decimals="false" :examples="[
        'Greeting' => ['text' => 'Happy birthday, Emma', 'style' => 'script'],
        'Bold script name' => ['text' => 'Olivia Rose', 'style' => 'bold_script'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="All styles" name="variants" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A → 𝒜 (U+1D49C); B → ℬ (U+212C); e → ℯ (U+212F)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
