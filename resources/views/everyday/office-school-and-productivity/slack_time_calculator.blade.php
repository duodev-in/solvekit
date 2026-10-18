<x-calc.page
    title="Slack Time Calculator - SolveKit"
    description="Free slack time calculator: total float and free float of a project task from its early and late start and finish (critical path method)."
    lede="Work out how much a task can slip without delaying the project."
    about="In the critical path method, total float (slack) = late start − early start = late finish − early finish. A task with zero float is on the critical path. Free float = the next task's early start − this task's early finish: how much it can slip without delaying the next task."
    :calc="['engine' => 'ev-office', 'tool' => 'slack', 'fields' => ['es', 'ef', 'ls', 'lf', 'next_es']]"
    :how-to="[
        ['name' => 'Enter the task\'s dates', 'text' => 'From a forward and backward pass.'],
        ['name' => 'Add the next task', 'text' => 'For free float.'],
    ]"
    :faqs="[
        ['question' => 'What is slack time?', 'answer' => 'How long a task can be delayed without delaying the project.'],
        ['question' => 'What does zero slack mean?', 'answer' => 'The task is on the critical path.'],
        ['question' => 'Total vs free float?', 'answer' => 'Free float only protects the next task\'s start.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="es" label="Early start" value="4" min="0" suffix="day" />
        <x-calc.field name="ef" label="Early finish" value="9" min="0" suffix="day" />
        <x-calc.field name="ls" label="Late start" value="7" min="0" suffix="day" />
        <x-calc.field name="lf" label="Late finish" value="12" min="0" suffix="day" />
    </div>

    <x-calc.field name="next_es" label="Next task's early start (optional)" value="10" min="0" suffix="day" />

    <x-calc.result label="Total float (slack)" />

    <x-calc.options :examples="[
        'Task with 3 days float' => ['es' => 4, 'ef' => 9, 'ls' => 7, 'lf' => 12, 'next_es' => 10],
        'Critical task' => ['es' => 0, 'ef' => 5, 'ls' => 0, 'lf' => 5, 'next_es' => 5],
        'Weeks' => ['es' => 2, 'ef' => 6, 'ls' => 5, 'lf' => 9, 'next_es' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'check' => ['label' => 'Check'],
            'free' => ['label' => 'Free float'],
            'duration' => ['label' => 'Duration'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TF = LS − ES = LF − EF</li>
            <li>FF = ES(next) − EF</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
