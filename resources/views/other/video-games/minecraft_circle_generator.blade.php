<x-calc.page
    title="Minecraft Circle Generator - SolveKit"
    description="Free Minecraft circle generator: block-by-block circles and ellipses, hollow or filled, with block counts."
    lede="Plan a Minecraft circle."
    about="Circles in Minecraft are built from square blocks; the plan shows which blocks to place."
    :calc="['engine' => 'ot-play', 'tool' => 'mc_circle', 'fields' => ['width', 'height', 'style', 'thick'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many blocks in a hollow 21-block circle?', 'answer' => '56.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="width" label="Width (blocks)" value="21" min="1" step="any" />
        <x-calc.field name="height" label="Height (blocks; same as width for a circle)" value="21" min="1" step="any" />
        <x-calc.select name="style" label="Style" :options="['hollow' => 'Hollow (outline)', 'filled' => 'Filled']" selected="hollow" />
        <div data-show-when="style:hollow">
            <x-calc.field name="thick" label="Wall thickness (hollow)" value="1" min="1" step="any" />
        </div>
    </div>

    <x-calc.result label="Blocks" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['width' => 21, 'height' => 21, 'style' => 'hollow', 'thick' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Block plan" name="grid" />
        <x-calc.rows heading="Details" :rows="[
            'rows' => ['label' => 'Blocks per row (top half)'],
            'size' => ['label' => 'Size'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
