<x-calc.page
    title="Nether Portal Calculator - SolveKit"
    description="Free Nether portal calculator: matching Overworld and Nether coordinates for linked portals."
    lede="Link Nether portals."
    about="One block in the Nether is eight in the Overworld, so portal coordinates are divided or multiplied by 8."
    :calc="['engine' => 'ot-play', 'tool' => 'nether_portal', 'fields' => ['from', 'x', 'y', 'z'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Where should the Nether portal for X 1200, Z −340 go?', 'answer' => 'X 150, Z -43.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="from" label="Coordinates are in" :options="['overworld' => 'The Overworld', 'nether' => 'The Nether']" selected="overworld" />
        <x-calc.field name="x" label="X" value="1200" step="any" />
        <x-calc.field name="y" label="Y" value="70" step="any" />
        <x-calc.field name="z" label="Z" value="-340" step="any" />
    </div>

    <x-calc.result label="Matching portal location" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['from' => 'overworld', 'x' => 1200, 'y' => 70, 'z' => -340],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'y' => ['label' => 'Y level'],
            'note' => ['label' => 'Linking'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
