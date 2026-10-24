<x-calc.page
    title="Minecraft Stack Calculator - SolveKit"
    description="Free Minecraft stack calculator: stacks, shulker boxes and chests for any number of items."
    lede="Count Minecraft stacks."
    about="Most items stack to 64, some to 16, tools to 1."
    :calc="['engine' => 'ot-play', 'tool' => 'mc_stack', 'fields' => ['items', 'stack'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many stacks are 3,500 blocks?', 'answer' => '54 stacks + 44.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="items" label="Number of items" value="3500" min="0" step="any" />
        <x-calc.select name="stack" label="Stack size" :options="['1' => '1 (tools, armour)', '16' => '16 (eggs, snowballs, signs…)', '64' => '64 (most blocks)']" selected="64" />
    </div>

    <x-calc.result label="Stacks" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => 3500, 'stack' => '64'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'leftover' => ['label' => 'Leftover items'],
            'shulkers' => ['label' => 'Shulker boxes (27 slots)'],
            'chests' => ['label' => 'Double chests (54 slots)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
