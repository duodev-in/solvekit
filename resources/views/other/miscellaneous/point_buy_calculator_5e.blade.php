<x-calc.page
    title="Point Buy Calculator 5e - SolveKit"
    description="Free D&D 5e point buy calculator: points spent of 27, with racial bonuses and modifiers."
    lede="Plan your ability scores."
    about="Point buy spends 27 points on six ability scores between 8 and 15."
    :calc="['engine' => 'ot-play', 'tool' => 'point_buy', 'fields' => ['str', 'dex', 'con', 'int', 'wis', 'cha', 'bonus'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Do 15, 14, 13, 12, 10, 8 use all 27 points?', 'answer' => '27 / 27.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="str" label="Strength" value="15" min="8" step="any" />
        <x-calc.field name="dex" label="Dexterity" value="14" min="8" step="any" />
        <x-calc.field name="con" label="Constitution" value="13" min="8" step="any" />
        <x-calc.field name="int" label="Intelligence" value="12" min="8" step="any" />
        <x-calc.field name="wis" label="Wisdom" value="10" min="8" step="any" />
        <x-calc.field name="cha" label="Charisma" value="8" min="8" step="any" />
        <x-calc.field name="bonus" label="Racial or background bonuses (e.g. +2 str +1 con)" value="+2 str +1 con" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Points spent" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['str' => 15, 'dex' => 14, 'con' => 13, 'int' => 12, 'wis' => 10, 'cha' => 8, 'bonus' => '+2 str +1 con'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'left' => ['label' => 'Points left of 27'],
            'final' => ['label' => 'Final scores (modifiers)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
