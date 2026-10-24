<x-calc.page
    title="Hash Identifier - SolveKit"
    description="Free hash identifier: guess the hash type (MD5, SHA-1, SHA-256, bcrypt …) from its length and format."
    lede="Identify a hash."
    about="Hash types can be told apart by their length, characters and format markers, though several algorithms share a length."
    :calc="['engine' => 'tc-text', 'tool' => 'hash_identifier', 'fields' => ['hash'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What hash is 5d41402abc4b2a76b9719d911017c592?', 'answer' => 'Most likely MD5, NTLM, MD4, MD2, LM (two halves).'],
    ]"
>
    <x-calc.field name="hash" label="Hash" value="5d41402abc4b2a76b9719d911017c592" type="text" inputmode="text" />

    <x-calc.result label="Possible hash types" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hash' => '5d41402abc4b2a76b9719d911017c592'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kind' => ['label' => 'Format'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
