<x-calc.page
    title="Vocal Range Calculator - SolveKit"
    description="Free vocal range calculator: your range in octaves and likely voice type from your lowest and highest notes."
    lede="Find your voice type."
    about="Voice types (bass to soprano) are partly defined by range, partly by tone."
    :calc="['engine' => 'tc-music', 'tool' => 'vocal_range', 'fields' => ['low', 'high'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What voice type sings A2 to A4?', 'answer' => 'Likely Baritone.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="low" label="Lowest note you sing comfortably" value="A2" type="text" inputmode="text" />
        <x-calc.field name="high" label="Highest note" value="A4" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Likely voice type" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['low' => 'A2', 'high' => 'A4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'span' => ['label' => 'Range'],
            'middle' => ['label' => 'Middle of your range'],
            'types' => ['label' => 'Types that cover your range'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
