<x-calc.page
    title="Pyramid Block Calculator - SolveKit"
    description="Free pyramid block calculator: blocks for a stepped pyramid, solid or hollow, layer by layer."
    lede="Count pyramid blocks."
    about="A stepped pyramid shrinks by a set amount each layer; the blocks add up layer by layer."
    :calc="['engine' => 'ot-play', 'tool' => 'pyramid', 'fields' => ['base', 'step', 'style'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many blocks for a solid 21-wide pyramid?', 'answer' => '1,771.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="base" label="Base width (blocks)" value="21" min="1" step="any" />
        <x-calc.field name="step" label="Step in per layer (each side)" value="1" min="1" step="any" />
        <x-calc.select name="style" label="Build" :options="['solid' => 'Solid', 'hollow' => 'Hollow (one-block shell)']" selected="solid" />
    </div>

    <x-calc.result label="Blocks needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['base' => 21, 'step' => 1, 'style' => 'solid'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'layers' => ['label' => 'Layers (height)'],
            'top' => ['label' => 'Top layer'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Blocks per layer" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
