<x-calc.page
    title="Vertical Exaggeration Calculator - SolveKit"
    description="Free vertical exaggeration calculator: VE of a profile or model from its horizontal and vertical scales."
    lede="Find the vertical exaggeration."
    about="Profiles and relief models often stretch heights to make terrain visible."
    :calc="['engine' => 'tc-photo', 'tool' => 'vert_exag', 'fields' => ['hscale', 'vscale'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the VE of 1:24,000 horizontal and 1:2,000 vertical?', 'answer' => '12×.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hscale" label="Horizontal scale" value="1:24000" type="text" inputmode="text" />
        <x-calc.field name="vscale" label="Vertical scale" value="1:2000" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Vertical exaggeration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['hscale' => '1:24000', 'vscale' => '1:2000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'meaning' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
