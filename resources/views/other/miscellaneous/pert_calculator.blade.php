<x-calc.page
    title="PERT Calculator - SolveKit"
    description="Free PERT calculator: expected project duration, standard deviation and chance to meet a deadline."
    lede="Estimate a project with PERT."
    about="PERT weights the most likely time four times as much as the best and worst cases."
    :calc="['engine' => 'ot-misc', 'tool' => 'pert', 'fields' => ['tasks', 'deadline'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the expected duration of the example?', 'answer' => '24.83 days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="tasks" label="Tasks on the critical path: name, optimistic, most likely, pessimistic (days)" value="Design, 3, 5, 10
Build, 8, 12, 20
Test, 2, 4, 9
Launch, 1, 2, 4" rows="4" />
        <x-calc.field name="deadline" label="Deadline (days, optional)" value="28" min="0" step="any" />
    </div>

    <x-calc.result label="Expected duration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['tasks' => 'Design, 3, 5, 10
Build, 8, 12, 20
Test, 2, 4, 9
Launch, 1, 2, 4', 'deadline' => 28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sd' => ['label' => 'Standard deviation'],
            'chance' => ['label' => 'Chance to finish by the deadline'],
            'p90' => ['label' => '90% confidence date'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Each task" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
