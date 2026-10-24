<x-calc.page
    title="Chord Inversion Calculator - SolveKit"
    description="Free chord inversion calculator: every inversion of a chord with slash symbols and figured bass."
    lede="Find chord inversions."
    about="An inversion puts a note other than the root in the bass."
    :calc="['engine' => 'tc-music', 'tool' => 'chord_inversion', 'fields' => ['chord'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many positions does G7 have?', 'answer' => '4 positions: root position and three inversions.'],
    ]"
>
    <x-calc.field name="chord" label="Chord symbol" value="G7" type="text" inputmode="text" />

    <x-calc.result label="Inversions" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['chord' => 'G7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'notes' => ['label' => 'Root position notes'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Every inversion" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
