<x-calc.page
    title="Base64 Encoder & Decoder - SolveKit"
    description="Free Base64 encoder and decoder: encode text to Base64 or decode it, standard or URL-safe."
    lede="Encode and decode Base64."
    about="Base64 writes any bytes using 64 safe characters, so binary data can travel in text such as email or URLs."
    :calc="['engine' => 'tc-text', 'tool' => 'base64', 'fields' => ['mode', 'text', 'b64', 'url'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the example text in Base64?', 'answer' => 'SGVsbG8sIEJhc2U2NCEg4pyT.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Mode" :options="['encode' => 'Encode text → Base64', 'decode' => 'Decode Base64 → text']" selected="encode" />
        <x-calc.textarea name="text" label="Text" value="Hello, Base64! ✓" rows="3" />
        <x-calc.textarea name="b64" label="Base64" value="SGVsbG8sIEJhc2U2NCEg4pyT" rows="3" />
        <x-calc.select name="url" label="Alphabet" :options="['std' => 'Standard (+ / and = padding)', 'url' => 'URL-safe (- _ without padding)']" selected="std" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'encode', 'text' => 'Hello, Base64! ✓', 'b64' => 'SGVsbG8sIEJhc2U2NCEg4pyT', 'url' => 'std'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bytes' => ['label' => 'Bytes'],
            'chars' => ['label' => 'Characters out'],
            'overhead' => ['label' => 'Size change'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
