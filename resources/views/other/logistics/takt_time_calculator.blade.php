<x-calc.page
    title="Takt Time Calculator - SolveKit"
    description="Free takt time calculator: production pace needed to meet demand, with operators needed."
    lede="Find the takt time."
    about="Takt time is the pace of production that matches customer demand."
    :calc="['engine' => 'ot-misc', 'tool' => 'takt', 'fields' => ['minutes', 'demand', 'cycle'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the takt time for 300 units in 450 minutes?', 'answer' => '90 s per unit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="minutes" label="Available production time per shift (minutes)" value="450" min="0" step="any" />
        <x-calc.field name="demand" label="Customer demand per shift (units)" value="300" min="1" step="any" />
        <x-calc.field name="cycle" label="Total work content per unit (seconds, optional)" value="360" min="0" step="any" />
    </div>

    <x-calc.result label="Takt time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['minutes' => 450, 'demand' => 300, 'cycle' => 360],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perHour' => ['label' => 'Units per hour needed'],
            'operators' => ['label' => 'Operators (stations) needed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
