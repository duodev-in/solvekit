<x-calc.page
    title="Tinetti Calculator - SolveKit"
    description="Free Tinetti calculator: the Performance Oriented Mobility Assessment (POMA), balance and gait items scored to 28, with fall risk."
    lede="Score balance and gait (Tinetti POMA)."
    about="The Tinetti POMA (Tinetti 1986) scores balance (16 points) and gait (12 points). 24–28 is low fall risk, 19–23 moderate and 18 or less high. It is done by trained staff watching the person sit, stand, turn and walk. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-scores', 'tool' => 'score', 'fields' => ['sitting', 'arises', 'attempts', 'immediate', 'standing', 'nudged', 'eyes', 'turn_steps', 'turn_steady', 'sitting_down', 'initiation', 'r_pass', 'r_clear', 'l_pass', 'l_clear', 'symmetry', 'continuity', 'path', 'trunk', 'stance'], 'data' => ['score' => config('health_data.scores.tinetti')]]"
    :how-to="[
        ['name' => 'Answer each item', 'text' => 'As defined by the published instrument.'],
        ['name' => 'Read the score and band', 'text' => 'The bands use the authors\' cut-offs.'],
    ]"
    :faqs="[
        ['question' => 'What does using arms to stand and a slightly wide stance score?', 'answer' => '26 of 28: Low fall risk (24–28).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="sitting" label="Balance: Sitting balance" :options="['o0' => 'Leans or slides in chair (0 points)', 'o1' => 'Steady, safe (1 point)']" selected="o1" />
        <x-calc.select name="arises" label="Balance: Arises from chair" :options="['o0' => 'Unable without help (0 points)', 'o1' => 'Able, uses arms (1 point)', 'o2' => 'Able without using arms (2 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="attempts" label="Balance: Attempts to arise" :options="['o0' => 'Unable without help (0 points)', 'o1' => 'Able, needs more than one attempt (1 point)', 'o2' => 'Able in one attempt (2 points)']" selected="o2" />
        <x-calc.select name="immediate" label="Balance: Immediate standing balance (first 5 seconds)" :options="['o0' => 'Unsteady (0 points)', 'o1' => 'Steady but uses a walker or support (1 point)', 'o2' => 'Steady without support (2 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="standing" label="Balance: Standing balance" :options="['o0' => 'Unsteady (0 points)', 'o1' => 'Steady but wide stance or uses support (1 point)', 'o2' => 'Narrow stance without support (2 points)']" selected="o2" />
        <x-calc.select name="nudged" label="Balance: Nudged (eyes open, feet together)" :options="['o0' => 'Begins to fall (0 points)', 'o1' => 'Staggers or grabs but catches self (1 point)', 'o2' => 'Steady (2 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="eyes" label="Balance: Eyes closed" :options="['o0' => 'Unsteady (0 points)', 'o1' => 'Steady (1 point)']" selected="o1" />
        <x-calc.select name="turn_steps" label="Balance: Turning 360°: steps" :options="['o0' => 'Discontinuous steps (0 points)', 'o1' => 'Continuous steps (1 point)']" selected="o1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="turn_steady" label="Balance: Turning 360°: steadiness" :options="['o0' => 'Unsteady (grabs or staggers) (0 points)', 'o1' => 'Steady (1 point)']" selected="o1" />
        <x-calc.select name="sitting_down" label="Balance: Sitting down" :options="['o0' => 'Unsafe (misjudges distance, falls into chair) (0 points)', 'o1' => 'Uses arms or not a smooth motion (1 point)', 'o2' => 'Safe, smooth motion (2 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="initiation" label="Gait: Gait initiation" :options="['o0' => 'Any hesitancy or several attempts (0 points)', 'o1' => 'No hesitancy (1 point)']" selected="o1" />
        <x-calc.select name="r_pass" label="Gait: Right swing foot passes the left stance foot" :options="['o0' => 'No (0 points)', 'o1' => 'Yes (1 point)']" selected="o1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="r_clear" label="Gait: Right foot completely clears the floor" :options="['o0' => 'No (0 points)', 'o1' => 'Yes (1 point)']" selected="o1" />
        <x-calc.select name="l_pass" label="Gait: Left swing foot passes the right stance foot" :options="['o0' => 'No (0 points)', 'o1' => 'Yes (1 point)']" selected="o1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="l_clear" label="Gait: Left foot completely clears the floor" :options="['o0' => 'No (0 points)', 'o1' => 'Yes (1 point)']" selected="o1" />
        <x-calc.select name="symmetry" label="Gait: Step symmetry" :options="['o0' => 'Right and left step length unequal (0 points)', 'o1' => 'Equal (1 point)']" selected="o1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="continuity" label="Gait: Step continuity" :options="['o0' => 'Stopping or discontinuity between steps (0 points)', 'o1' => 'Steps appear continuous (1 point)']" selected="o1" />
        <x-calc.select name="path" label="Gait: Path (over about 3 m)" :options="['o0' => 'Marked deviation (0 points)', 'o1' => 'Mild or moderate deviation, or uses an aid (1 point)', 'o2' => 'Straight without an aid (2 points)']" selected="o2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="trunk" label="Gait: Trunk" :options="['o0' => 'Marked sway or uses an aid (0 points)', 'o1' => 'No sway but flexes knees or back, or spreads arms (1 point)', 'o2' => 'No sway, no flexion, no use of arms or aid (2 points)']" selected="o2" />
        <x-calc.select name="stance" label="Gait: Walking stance" :options="['o0' => 'Heels apart (0 points)', 'o1' => 'Heels almost touching while walking (1 point)']" selected="o1" />
    </div>

    <x-calc.result label="Tinetti Performance Oriented Mobility Assessment" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['sitting' => 'o1', 'arises' => 'o2', 'attempts' => 'o2', 'immediate' => 'o2', 'standing' => 'o2', 'nudged' => 'o2', 'eyes' => 'o1', 'turn_steps' => 'o1', 'turn_steady' => 'o1', 'sitting_down' => 'o2', 'initiation' => 'o1', 'r_pass' => 'o1', 'r_clear' => 'o1', 'l_pass' => 'o1', 'l_clear' => 'o1', 'symmetry' => 'o1', 'continuity' => 'o1', 'path' => 'o2', 'trunk' => 'o2', 'stance' => 'o1'],
        'Highest' => ['sitting' => 'o1', 'arises' => 'o2', 'attempts' => 'o2', 'immediate' => 'o2', 'standing' => 'o2', 'nudged' => 'o2', 'eyes' => 'o1', 'turn_steps' => 'o1', 'turn_steady' => 'o1', 'sitting_down' => 'o2', 'initiation' => 'o1', 'r_pass' => 'o1', 'r_clear' => 'o1', 'l_pass' => 'o1', 'l_clear' => 'o1', 'symmetry' => 'o1', 'continuity' => 'o1', 'path' => 'o2', 'trunk' => 'o2', 'stance' => 'o1'],
        'Uses arms' => ['sitting' => 'o1', 'arises' => 'o1', 'attempts' => 'o2', 'immediate' => 'o2', 'standing' => 'o1', 'nudged' => 'o2', 'eyes' => 'o1', 'turn_steps' => 'o1', 'turn_steady' => 'o1', 'sitting_down' => 'o2', 'initiation' => 'o1', 'r_pass' => 'o1', 'r_clear' => 'o1', 'l_pass' => 'o1', 'l_clear' => 'o1', 'symmetry' => 'o1', 'continuity' => 'o1', 'path' => 'o2', 'trunk' => 'o2', 'stance' => 'o1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'band' => ['label' => 'Band'],
            'meaning' => ['label' => 'What it means'],
            'counted' => ['label' => 'Points counted'],
            'source' => ['label' => 'Reference'],
        ]" />
        <x-calc.grid heading="Items" name="items" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Tinetti Performance Oriented Mobility Assessment: sum of item points (maximum 28)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
