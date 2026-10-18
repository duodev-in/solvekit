<x-calc.page
    title="Italic Text Generator - SolveKit"
    description="Free italic text generator: turn text into italic Unicode letters to copy and paste into apps that do not support italics."
    lede="Make italic text to copy and paste."
    about="Letters are swapped for Unicode Mathematical Italic characters (U+1D434 onward); italic h uses ℎ (U+210E). Digits have no italic form. They are special Unicode letters, not a font, so they paste into social media bios, posts and messages. Some apps, screen readers and search engines do not read them as normal letters, so avoid them for important text."
    :calc="['engine' => 'ev-fun', 'tool' => 'italic', 'fields' => ['text', 'style']]"
    :how-to="[
        ['name' => 'Type or paste your text', 'text' => 'It converts as you type.'],
        ['name' => 'Copy the result', 'text' => 'With the Copy button.'],
    ]"
    :faqs="[
        ['question' => 'How do I write in italics on social media?', 'answer' => 'Convert here and paste.'],
        ['question' => 'Why are numbers not italic?', 'answer' => 'Unicode has no italic digits.'],
        ['question' => 'Will it show everywhere?', 'answer' => 'Almost all modern devices show these characters.'],
    ]"
>
    <x-calc.textarea name="text" label="Your text" value="Slanted for emphasis" rows="3" />

    <x-calc.select name="style" label="Style" :options="['italic' => 'Italic serif', 'sans_italic' => 'Italic sans-serif', 'bold_italic' => 'Bold italic', 'sans_bold_italic' => 'Bold italic sans']" selected="italic" />

    <x-calc.result label="Converted text" />

    <x-calc.options :decimals="false" :examples="[
        'Emphasis' => ['text' => 'Slanted for emphasis', 'style' => 'italic'],
        'Sans' => ['text' => 'Note to self', 'style' => 'sans_italic'],
        'Bold italic' => ['text' => 'Do not miss this', 'style' => 'bold_italic'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="All styles" name="variants" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A → 𝐴 (U+1D434), h → ℎ (U+210E)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
