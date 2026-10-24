<x-calc.page
    title="Minecraft Chunk Calculator - SolveKit"
    description="Free Minecraft chunk calculator: chunk, position inside it and region file for any block coordinates."
    lede="Find a Minecraft chunk."
    about="Minecraft worlds are stored in 16 × 16 chunks, grouped into region files of 32 × 32 chunks."
    :calc="['engine' => 'ot-play', 'tool' => 'mc_chunk', 'fields' => ['x', 'z'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Which chunk holds block −1234, 5678?', 'answer' => 'Chunk -78, 354.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Block X" value="-1234" step="any" />
        <x-calc.field name="z" label="Block Z" value="5678" step="any" />
    </div>

    <x-calc.result label="Chunk" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => -1234, 'z' => 5678],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'inChunk' => ['label' => 'Position inside the chunk'],
            'corners' => ['label' => 'Chunk corners (X, Z)'],
            'region' => ['label' => 'Region file'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
