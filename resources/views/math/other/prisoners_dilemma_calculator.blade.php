<x-calc.page
    title="Prisoner's Dilemma Calculator - SolveKit"
    description="Prisoner's dilemma calculator: an iterated round-robin tournament of classic strategies (tit for tat, grim trigger, Pavlov and more) with your payoffs."
    lede="Run a prisoner's dilemma tournament."
    about="Two players each cooperate or defect. Defecting always pays more in one round (T > R and P > S), yet both defecting (P) is worse than both cooperating (R). Repeated many times, as in Axelrod's tournaments, nice but retaliating strategies such as tit for tat score best."
    :calc="['engine' => 'mt-other', 'tool' => 'prisoner', 'fields' => ['t', 'r', 'p', 's', 'rounds', 'strategies']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'Which classic strategy wins a 200-round tournament with payoffs 5, 3, 1, 0?', 'answer' => 'Grim trigger.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="t" label="Temptation T" value="5" step="any" />
        <x-calc.field name="r" label="Reward R" value="3" step="any" />
        <x-calc.field name="p" label="Punishment P" value="1" step="any" />
        <x-calc.field name="s" label="Sucker S" value="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rounds" label="Rounds per match" value="200" min="1" max="1000" step="1" />
        <x-calc.field name="strategies" label="Strategies" value="tft, allc, alld, grim, tf2t, pavlov, random, gtft" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Tournament winner" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['t' => 5, 'r' => 3, 'p' => 1, 's' => 0, 'rounds' => 200, 'strategies' => 'tft, allc, alld, grim, tf2t, pavlov, random, gtft'],
        'Short' => ['t' => 5, 'r' => 3, 'p' => 1, 's' => 0, 'rounds' => 5, 'strategies' => 'tft, allc, alld, grim, tf2t, pavlov, random, gtft'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ranking' => ['label' => 'Ranking'],
            'payoffs' => ['label' => 'Payoffs'],
            'lesson' => ['label' => 'Lesson'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Scores (row against column)" name="scores" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T > R > P > S</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
