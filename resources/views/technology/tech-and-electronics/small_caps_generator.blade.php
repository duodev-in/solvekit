<x-calc.page
    title="Small Caps Generator - SolveKit"
    description="Free small caps generator: turn text into Unicode small capital letters to copy and paste."
    lede="Make small caps text."
    about="Small capitals look like capital letters at lowercase height."
    :calc="['engine' => 'tc-text', 'tool' => 'small_caps', 'fields' => ['text'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does the example look like?', 'answer' => 'ꜱᴍᴀʟʟ ᴄᴀᴘꜱ ᴛᴇxᴛ.'],
    ]"
>
    <x-calc.textarea name="text" label="Text" value="Small Caps Text" rows="3" />

    <x-calc.result label="Small caps" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['text' => 'Small Caps Text'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'note' => ['label' => 'Not converted'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
