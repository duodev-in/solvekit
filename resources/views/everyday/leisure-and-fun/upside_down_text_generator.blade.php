<x-calc.page
    title="Upside-Down Text Generator - SolveKit"
    description="Free upside-down text generator: flip text upside down with look-alike Unicode characters to copy and paste."
    lede="Flip text upside down."
    about="Each character is swapped for a Unicode character that looks like it turned 180° (a → ɐ, e → ǝ, ? → ¿) and the order is reversed, so it reads correctly when the screen is turned over. Letters without a turned look-alike stay the same."
    :calc="['engine' => 'ev-fun', 'tool' => 'upside_down', 'fields' => ['text']]"
    :how-to="[
        ['name' => 'Type or paste your text', 'text' => 'It converts as you type.'],
        ['name' => 'Copy the result', 'text' => 'With the Copy button.'],
    ]"
    :faqs="[
        ['question' => 'How do I type upside down?', 'answer' => 'Type normally here and copy the flipped result.'],
        ['question' => 'Why do some letters not flip?', 'answer' => 'Not every letter has an upside-down look-alike in Unicode.'],
        ['question' => 'Can I flip it back?', 'answer' => 'Paste the flipped text in again.'],
    ]"
>
    <x-calc.textarea name="text" label="Your text" value="Hello, world!" rows="3" />

    <x-calc.result label="Converted text" />

    <x-calc.options :decimals="false" :examples="[
        'Hello, world!' => ['text' => 'Hello, world!'],
        'Question' => ['text' => 'Are you upside down?'],
        'Numbers' => ['text' => '1234567890'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="All styles" name="variants" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>reverse, then swap each character for its turned look-alike</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
