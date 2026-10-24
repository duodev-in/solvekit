<x-calc.page
    title="Gothic Font Generator - SolveKit"
    description="Free gothic font generator: turn text into Fraktur (blackletter) Unicode letters to copy and paste."
    lede="Make gothic text."
    about="Gothic or blackletter letters come from Unicode’s Mathematical Fraktur characters, so they paste into bios and posts."
    :calc="['engine' => 'tc-text', 'tool' => 'gothic', 'fields' => ['text', 'style'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does the example look like?', 'answer' => '𝔊𝔬𝔱𝔥𝔦𝔠 𝔏𝔢𝔱𝔱𝔢𝔯𝔰.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="text" label="Text" value="Gothic Letters" rows="3" />
        <x-calc.select name="style" label="Style" :options="['fraktur' => 'Fraktur 𝔊𝔬𝔱𝔥𝔦𝔠', 'bold' => 'Bold Fraktur 𝕲𝖔𝖙𝖍𝖎𝖈']" selected="fraktur" />
    </div>

    <x-calc.result label="Gothic text" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'Gothic Letters', 'style' => 'fraktur'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'other' => ['label' => 'The other style'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
