<x-calc.page
    title="Hash Generator - SolveKit"
    description="Free hash generator: MD5, SHA-1, SHA-256 and SHA-512 of any text, computed in your browser."
    lede="Hash text."
    about="A hash turns any text into a fixed-length fingerprint; the same text always gives the same hash."
    :calc="['engine' => 'tc-text', 'tool' => 'hash_gen', 'fields' => ['text', 'algo'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the SHA-256 hash of “hello”?', 'answer' => '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="hello" rows="3" />
        <x-calc.select name="algo" label="Show as the main result" :options="['sha256' => 'SHA-256', 'sha1' => 'SHA-1', 'sha512' => 'SHA-512', 'md5' => 'MD5']" selected="sha256" />
    </div>

    <x-calc.result label="Hash" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'hello', 'algo' => 'sha256'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'md5' => ['label' => 'MD5'],
            'sha1' => ['label' => 'SHA-1'],
            'sha256' => ['label' => 'SHA-256'],
            'sha512' => ['label' => 'SHA-512'],
            'bytes' => ['label' => 'Input bytes (UTF-8)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
