<x-calc.page
    title="Recruitment Process Duration Calculator - SolveKit"
    description="Free recruitment duration calculator: time to hire from your stages, with the expected start date."
    lede="Plan a hiring timeline."
    about="Time to hire is the sum of the recruitment stages, from approving the job to the new hire starting."
    :calc="['engine' => 'ot-misc', 'tool' => 'recruitment', 'fields' => ['stages', 'start'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long does the example process take?', 'answer' => '60 working days.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="stages" label="Stages: name, working days (one per line)" value="Write and approve the job, 5
Advertise, 15
Screen applications, 5
Interviews, 10
Offer and acceptance, 5
Notice period, 20" rows="6" />
        <x-calc.field name="start" label="Start date" value="2026-11-02" type="date" />
    </div>

    <x-calc.result label="Total time to hire" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['stages' => 'Write and approve the job, 5
Advertise, 15
Screen applications, 5
Interviews, 10
Offer and acceptance, 5
Notice period, 20', 'start' => '2026-11-02'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'finish' => ['label' => 'Expected start date (working days)'],
            'calendar' => ['label' => 'In calendar weeks'],
            'longest' => ['label' => 'Longest stage'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Timeline" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
