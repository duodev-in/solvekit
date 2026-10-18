<x-calc.page
    title="Glitch Text Generator - SolveKit"
    description="Free glitch text generator: Zalgo-style creepy, glitchy text made of stacked Unicode combining marks, with adjustable intensity."
    lede="Make creepy glitch (Zalgo) text."
    about="Combining marks such as U+0300–U+036F are stacked above, through and below each letter. The same text and seed always give the same result; change the seed for a new pattern. Heavy glitch text can overflow lines and is unreadable to screen readers."
    :calc="['engine' => 'ev-fun', 'tool' => 'glitch', 'fields' => ['text', 'intensity', 'seed']]"
    :how-to="[
        ['name' => 'Type or paste your text', 'text' => 'It converts as you type.'],
        ['name' => 'Copy the result', 'text' => 'With the Copy button.'],
    ]"
    :faqs="[
        ['question' => 'What is Zalgo text?', 'answer' => 'Text covered in stacked combining marks so it looks glitched.'],
        ['question' => 'Why does it spill onto other lines?', 'answer' => 'The marks stack above and below the letters.'],
        ['question' => 'How do I get a different look?', 'answer' => 'Change the seed or intensity.'],
    ]"
>
    <x-calc.textarea name="text" label="Your text" value="Something is wrong" rows="3" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="intensity" label="Intensity" value="3" min="1" max="8" step="1" />
        <x-calc.field name="seed" label="Seed" value="1" min="1" step="1" />
    </div>

    <x-calc.result label="Converted text" />

    <x-calc.options :decimals="false" :examples="[
        'Creepy' => ['text' => 'Something is wrong', 'intensity' => 3, 'seed' => 1],
        'Light glitch' => ['text' => 'Loading…', 'intensity' => 1, 'seed' => 4],
        'Heavy' => ['text' => 'HELP', 'intensity' => 6, 'seed' => 7],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>each letter + intensity × (mark above + mark below)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
