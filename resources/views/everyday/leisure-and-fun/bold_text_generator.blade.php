<x-calc.page
    title="Bold Text Generator - SolveKit"
    description="Free bold text generator: turn text into bold Unicode letters you can paste into Instagram, X, Facebook and other apps that do not offer bold."
    lede="Make bold text to copy and paste anywhere."
    about="Letters A–Z, a–z and digits are swapped for the Mathematical Bold characters of Unicode (U+1D400 onward). They are special Unicode letters, not a font, so they paste into social media bios, posts and messages. Some apps, screen readers and search engines do not read them as normal letters, so avoid them for important text."
    :calc="['engine' => 'ev-fun', 'tool' => 'bold', 'fields' => ['text', 'style']]"
    :how-to="[
        ['name' => 'Type or paste your text', 'text' => 'It converts as you type.'],
        ['name' => 'Copy the result', 'text' => 'With the Copy button.'],
    ]"
    :faqs="[
        ['question' => 'How do I write in bold on Instagram?', 'answer' => 'Paste text converted here; Instagram has no bold option of its own.'],
        ['question' => 'Why do some letters not change?', 'answer' => 'Only A–Z, a–z and 0–9 have bold versions; accented letters stay as they are.'],
        ['question' => 'Is it accessible?', 'answer' => 'Screen readers may read these characters oddly, so use them sparingly.'],
    ]"
>
    <x-calc.textarea name="text" label="Your text" value="Bold text for your bio" rows="3" />

    <x-calc.select name="style" label="Style" :options="['bold' => 'Bold serif', 'sans_bold' => 'Bold sans-serif', 'bold_italic' => 'Bold italic', 'sans_bold_italic' => 'Bold italic sans', 'bold_script' => 'Bold script']" selected="bold" />

    <x-calc.result label="Converted text" />

    <x-calc.options :decimals="false" :examples="[
        'Bio' => ['text' => 'Bold text for your bio', 'style' => 'bold'],
        'Sans heading' => ['text' => 'Big News 2026', 'style' => 'sans_bold'],
        'Italic emphasis' => ['text' => 'Read this first', 'style' => 'bold_italic'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="All styles" name="variants" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A → 𝐀 (U+1D400), a → 𝐚 (U+1D41A), 0 → 𝟎 (U+1D7CE)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
