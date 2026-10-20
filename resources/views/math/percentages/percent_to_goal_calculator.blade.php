<x-calc.page
    title="Percent to Goal Calculator - SolveKit"
    description="Free percent to goal calculator: how far you are towards a goal as a percentage, from a starting value if you have one."
    lede="See your progress towards a goal."
    about="Progress = (current − start) ÷ (goal − start) × 100. With no starting value it is simply current ÷ goal. It works for savings, sales targets, fundraising or weight goals, including goals that decrease."
    :calc="['engine' => 'mt-percent', 'tool' => 'goal', 'fields' => ['current', 'goal', 'start']]"
    :how-to="[
        ['name' => 'Enter the current value and goal', 'text' => ''],
        ['name' => 'Add a starting value', 'text' => 'Optional.'],
    ]"
    :faqs="[
        ['question' => 'How far is 3,400 towards 5,000?', 'answer' => '68%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="current" label="Current value" value="3,400" type="text" inputmode="decimal" />
        <x-calc.field name="goal" label="Goal" value="5,000" type="text" inputmode="decimal" />
        <x-calc.field name="start" label="Starting value (optional)" value="" type="text" placeholder="0" inputmode="decimal" />
    </div>

    <x-calc.result label="Of the goal reached" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['current' => '3400', 'goal' => '5000', 'start' => ''],
        'Weight loss' => ['current' => '84', 'goal' => '75', 'start' => '92'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'remaining' => ['label' => 'Still to go'],
            'remainingPct' => ['label' => 'Remaining'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(current − start) ÷ (goal − start) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
