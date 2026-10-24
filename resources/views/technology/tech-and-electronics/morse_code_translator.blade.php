<x-calc.page
    title="Morse Code Translator - SolveKit"
    description="Free Morse code translator: text to International Morse code and back, with sending time."
    lede="Translate Morse code."
    about="International Morse code encodes letters, digits and punctuation as dots and dashes (ITU-R M.1677-1)."
    :calc="['engine' => 'tc-text', 'tool' => 'morse', 'fields' => ['mode', 'text', 'code', 'wpm'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is “SOS Help” in Morse?', 'answer' => '... --- ... / .... . .-.. .--..'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Translate" :options="['toMorse' => 'Text → Morse', 'toText' => 'Morse → text']" selected="toMorse" />
        <x-calc.textarea name="text" label="Text" value="SOS Help" rows="3" />
        <x-calc.textarea name="code" label="Morse (letters separated by spaces, words by /)" value="... --- ... / .... . .-.. .--." rows="3" />
        <x-calc.field name="wpm" label="Speed (words per minute)" value="20" min="1" step="any" />
    </div>

    <x-calc.result label="Translation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'toMorse', 'text' => 'SOS Help', 'code' => '... --- ... / .... . .-.. .--.', 'wpm' => 20],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'units' => ['label' => 'Length in dot units'],
            'time' => ['label' => 'Time to send'],
            'unknown' => ['label' => 'Unknown characters'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
