<x-calc.page
    title="Encounter Calculator 5e - SolveKit"
    description="Free D&D 5e encounter calculator: encounter difficulty from party levels and monsters (2014 or 2024 rules)."
    lede="Rate a D&D encounter."
    about="Encounter difficulty compares the monsters’ XP with the party’s XP thresholds."
    :calc="['engine' => 'ot-play', 'tool' => 'dnd_encounter', 'fields' => ['rules', 'party', 'monsters'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['dnd_2014', 'dnd_2024', 'dnd_multipliers', 'dnd_cr_xp'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How hard is the example encounter?', 'answer' => 'Medium.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="rules" label="Rules" :options="['2014' => '2014 (DMG: thresholds and multipliers)', '2024' => '2024 (XP budget)']" selected="2014" />
        <x-calc.field name="party" label="Character levels (one per character)" value="5 5 5 4" type="text" inputmode="text" />
        <x-calc.textarea name="monsters" label="Monsters: challenge rating × count (one per line)" value="3 × 1
1/2 × 4" rows="3" />
    </div>

    <x-calc.result label="Difficulty" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rules' => '2014', 'party' => '5 5 5 4', 'monsters' => '3 × 1
1/2 × 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'xp' => ['label' => 'Monster XP'],
            'adjusted' => ['label' => 'Adjusted XP (2014)'],
            'budget' => ['label' => 'Party thresholds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
