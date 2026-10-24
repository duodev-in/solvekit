<x-calc.page
    title="Uptime Calculator - SolveKit"
    description="Free uptime calculator: allowed downtime per day, week, month and year for an SLA percentage."
    lede="Turn uptime into downtime."
    about="An uptime of 99.9% (three nines) still allows nearly nine hours of downtime a year."
    :calc="['engine' => 'tc-net', 'tool' => 'uptime', 'fields' => ['uptime'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much downtime does 99.9% allow per year?', 'answer' => '8 h 45 min 57 s.'],
    ]"
>
    <x-calc.field name="uptime" label="Uptime (%)" value="99.9" min="0" step="any" />

    <x-calc.result label="Downtime allowed per year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['uptime' => 99.9],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'day' => ['label' => 'Per day'],
            'week' => ['label' => 'Per week'],
            'month' => ['label' => 'Per month (30.44 days)'],
            'quarter' => ['label' => 'Per quarter'],
            'nines' => ['label' => 'Nines'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="The nines" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
