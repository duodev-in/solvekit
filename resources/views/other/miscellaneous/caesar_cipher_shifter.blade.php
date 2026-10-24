<x-calc.page
    title="Caesar Cipher Shifter - SolveKit"
    description="Free Caesar cipher: shift letters to encrypt or decrypt, or try every shift."
    lede="Use the Caesar cipher."
    about="The Caesar cipher shifts every letter a fixed number of places along the alphabet."
    :calc="['engine' => 'tc-text', 'tool' => 'caesar', 'fields' => ['text', 'shift', 'mode'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is “Veni, vidi, vici” shifted by 3?', 'answer' => 'Yhql, ylgl, ylfl.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="Veni, vidi, vici" rows="3" />
        <x-calc.field name="shift" label="Shift (key)" value="3" step="any" />
        <x-calc.select name="mode" label="Mode" :options="['encode' => 'Encrypt (shift forward)', 'decode' => 'Decrypt (shift back)', 'brute' => 'Try every shift']" selected="encode" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'Veni, vidi, vici', 'shift' => 3, 'mode' => 'encode'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'key' => ['label' => 'Shift used'],
            'rot13' => ['label' => 'ROT13'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Every possible shift" name="all" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
