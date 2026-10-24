<x-calc.page
    title="Vigenère Cipher Calculator - SolveKit"
    description="Free Vigenère cipher calculator: encrypt and decrypt with a keyword, letter by letter."
    lede="Use the Vigenère cipher."
    about="The Vigenère cipher shifts each letter by a different amount, taken from a repeating keyword."
    :calc="['engine' => 'tc-text', 'tool' => 'vigenere', 'fields' => ['text', 'key', 'mode'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is ATTACK AT DAWN with the key LEMON?', 'answer' => 'LXFOPV EF RNHR.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="ATTACK AT DAWN" rows="3" />
        <x-calc.field name="key" label="Key" value="LEMON" type="text" inputmode="text" />
        <x-calc.select name="mode" label="Mode" :options="['encrypt' => 'Encrypt', 'decrypt' => 'Decrypt']" selected="encrypt" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'ATTACK AT DAWN', 'key' => 'LEMON', 'mode' => 'encrypt'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'key' => ['label' => 'Key letters (shifts)'],
            'letters' => ['label' => 'Letters changed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Letter by letter (first 60)" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
