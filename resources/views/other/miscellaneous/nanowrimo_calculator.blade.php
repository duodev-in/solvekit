<x-calc.page
    title="NaNoWriMo Calculator - SolveKit"
    description="Free NaNoWriMo calculator: words per day to reach 50,000 words in November."
    lede="Stay on track for 50,000 words."
    about="The November novel challenge is 50,000 words in 30 days: 1,667 words a day."
    :calc="['engine' => 'ot-misc', 'tool' => 'nanowrimo', 'fields' => ['words', 'goal', 'date', 'end'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many words a day from 18,000 on 12 November?', 'answer' => '1,685.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="words" label="Words written so far" value="18000" min="0" step="any" />
        <x-calc.field name="goal" label="Goal (words)" value="50000" min="1" step="any" />
        <x-calc.field name="date" label="Today’s date" value="2026-11-12" type="date" />
        <x-calc.field name="end" label="Deadline" value="2026-11-30" type="date" />
    </div>

    <x-calc.result label="Words per day needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['words' => 18000, 'goal' => 50000, 'date' => '2026-11-12', 'end' => '2026-11-30'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'left' => ['label' => 'Words left'],
            'days' => ['label' => 'Days left (including today)'],
            'pace' => ['label' => 'Your pace so far (from 1 November)'],
            'finish' => ['label' => 'Finish date at your pace'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
