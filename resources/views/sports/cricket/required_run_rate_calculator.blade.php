<x-calc.page
    title="Required Run Rate Calculator - SolveKit"
    description="Free required run rate calculator: runs per over needed to reach a target."
    lede="Find the required run rate."
    about="The required run rate is the runs still needed divided by the overs left."
    :calc="['engine' => 'sp-ball', 'tool' => 'required_rate', 'fields' => ['target', 'score', 'left', 'done'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What rate is needed for 130 from 20 overs?', 'answer' => '6.50.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="target" label="Target" value="280" min="1" step="any" />
        <x-calc.field name="score" label="Current score" value="150" min="0" step="any" />
        <x-calc.field name="left" label="Overs left (12.3 = 12½)" value="20" min="0" step="any" />
        <x-calc.field name="done" label="Overs batted" value="30" min="0" step="any" />
    </div>

    <x-calc.result label="Required run rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['target' => 280, 'score' => 150, 'left' => 20, 'done' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'needed' => ['label' => 'Runs needed'],
            'perBall' => ['label' => 'Runs per ball'],
            'current' => ['label' => 'Current run rate'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
