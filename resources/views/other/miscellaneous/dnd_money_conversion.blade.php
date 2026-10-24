<x-calc.page
    title="DnD Money Conversion - SolveKit"
    description="Free D&D money converter: copper, silver, electrum, gold and platinum, with fewest coins and party shares."
    lede="Convert D&D coins."
    about="Dungeons & Dragons 5e uses five coins worth 1, 10, 50, 100 and 1,000 copper."
    :calc="['engine' => 'ot-play', 'tool' => 'dnd_money', 'fields' => ['cp', 'sp', 'ep', 'gp', 'pp', 'players'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the example hoard worth?', 'answer' => '161.5 gp.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cp" label="Copper (cp)" value="0" min="0" step="any" />
        <x-calc.field name="sp" label="Silver (sp)" value="35" min="0" step="any" />
        <x-calc.field name="ep" label="Electrum (ep)" value="2" min="0" step="any" />
        <x-calc.field name="gp" label="Gold (gp)" value="127" min="0" step="any" />
        <x-calc.field name="pp" label="Platinum (pp)" value="3" min="0" step="any" />
        <x-calc.field name="players" label="Split between players" value="4" min="1" step="any" />
    </div>

    <x-calc.result label="Total in gold" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cp' => 0, 'sp' => 35, 'ep' => 2, 'gp' => 127, 'pp' => 3, 'players' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'cp' => ['label' => 'In copper'],
            'fewest' => ['label' => 'Fewest coins (no electrum)'],
            'share' => ['label' => 'Each player’s share'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
