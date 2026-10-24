<x-calc.page
    title="HP Calculator 5e – Dungeons & Dragons - SolveKit"
    description="Free D&D 5e HP calculator: hit points by class, level and Constitution, average or rolled."
    lede="Find your D&D hit points."
    about="Hit points come from your class’s hit die and your Constitution modifier at every level."
    :calc="['engine' => 'ot-play', 'tool' => 'dnd_hp', 'fields' => ['cls', 'level', 'con', 'extra'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many HP does a level 5 fighter with Con 14 have?', 'answer' => '44.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="cls" label="Class" :options="['barbarian' => 'Barbarian (d12)', 'fighter' => 'Fighter (d10)', 'paladin' => 'Paladin (d10)', 'ranger' => 'Ranger (d10)', 'bard' => 'Bard (d8)', 'cleric' => 'Cleric (d8)', 'druid' => 'Druid (d8)', 'monk' => 'Monk (d8)', 'rogue' => 'Rogue (d8)', 'warlock' => 'Warlock (d8)', 'sorcerer' => 'Sorcerer (d6)', 'wizard' => 'Wizard (d6)']" selected="fighter" />
        <x-calc.field name="level" label="Level" value="5" min="1" step="any" />
        <x-calc.field name="con" label="Constitution score" value="14" min="1" step="any" />
        <x-calc.select name="extra" label="Extra HP per level" :options="['0' => 'None', '1' => 'Hill dwarf (+1)', '2' => 'Tough feat (+2)', '3' => 'Both (+3)']" selected="0" />
    </div>

    <x-calc.result label="Hit points (fixed average)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cls' => 'fighter', 'level' => 5, 'con' => 14, 'extra' => '0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'If rolled: minimum – maximum'],
            'perLevel' => ['label' => 'Gained each level after 1st'],
            'con' => ['label' => 'Constitution modifier'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
