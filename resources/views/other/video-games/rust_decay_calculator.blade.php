<x-calc.page
    title="Rust Decay Calculator - SolveKit"
    description="Free Rust decay calculator: time until a building decays by material and health."
    lede="Find Rust decay time."
    about="In Rust, buildings decay when the tool cupboard runs out of the material for upkeep."
    :calc="['engine' => 'ot-play', 'tool' => 'rust_decay', 'fields' => ['material', 'health'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['rust'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long does full-health stone take to decay?', 'answer' => '5 h.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="material" label="Building tier" :options="['twig' => 'Twig', 'wood' => 'Wood', 'stone' => 'Stone', 'metal' => 'Sheet metal', 'armored' => 'Armored (high quality metal)']" selected="stone" />
        <x-calc.field name="health" label="Current health (%)" value="100" min="0" step="any" />
    </div>

    <x-calc.result label="Time until it decays" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['material' => 'stone', 'health' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'full' => ['label' => 'Full decay time for this tier'],
            'note' => ['label' => 'Rules'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
