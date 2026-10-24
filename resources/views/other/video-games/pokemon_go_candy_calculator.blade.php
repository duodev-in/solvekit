<x-calc.page
    title="Pokémon Go Candy Calculator - SolveKit"
    description="Free Pokémon GO candy calculator: evolutions you can make, transfers needed and XP."
    lede="Plan your evolutions."
    about="Evolving costs candy and gives one back; transferring a Pokémon gives one candy."
    :calc="['engine' => 'ot-play', 'tool' => 'pogo_candy', 'fields' => ['candy', 'count', 'cost', 'lucky'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many evolutions from 600 candy and 40 Pidgey?', 'answer' => '40.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="candy" label="Candy you have" value="600" min="0" step="any" />
        <x-calc.field name="count" label="Pokémon of that species" value="40" min="0" step="any" />
        <x-calc.select name="cost" label="Evolution cost" :options="['12' => '12 (Caterpillar, Weedle, Pidgey, Wurmple …)', '25' => '25', '50' => '50', '100' => '100', '200' => '200', '400' => '400 (Magikarp, Wailmer …)']" selected="12" />
        <x-calc.select name="lucky" label="Lucky Egg active" :options="['no' => 'No', 'yes' => 'Yes (double XP)']" selected="yes" />
    </div>

    <x-calc.result label="Evolutions possible" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['candy' => 600, 'count' => 40, 'cost' => '12', 'lucky' => 'yes'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'transfers' => ['label' => 'Transfers needed first'],
            'leftover' => ['label' => 'Candy left after'],
            'xp' => ['label' => 'XP from evolutions'],
            'time' => ['label' => 'Time (about 25 s each)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
