<x-calc.page
    title="Cycle Time Calculator - SolveKit"
    description="Free cycle time calculator: average cycle time per unit, throughput per hour and takt time against customer demand."
    lede="Work out cycle time, throughput and takt time."
    about="Cycle time = production time ÷ units completed. Throughput = units per hour. Takt time = available time ÷ customer demand: the pace needed to meet demand. If the cycle time is longer than the takt time, the process cannot keep up."
    :calc="['engine' => 'ev-office', 'tool' => 'cycle_time', 'fields' => ['time', 'units', 'available', 'demand']]"
    :how-to="[
        ['name' => 'Enter time and units', 'text' => 'For one run or shift.'],
        ['name' => 'Add available time and demand', 'text' => 'For takt time.'],
    ]"
    :faqs="[
        ['question' => 'What is the cycle time for 96 units in 8 hours?', 'answer' => '5 minutes per unit, 12 units an hour.'],
        ['question' => 'What is takt time?', 'answer' => 'Available time ÷ demand: 7.5 hours for 100 units is 4.5 minutes each.'],
        ['question' => 'Cycle time vs lead time?', 'answer' => 'Cycle time is per unit at a step; lead time is from order to delivery.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="time" label="Production time" value="480" min="0" suffix="min" />
        <x-calc.field name="units" label="Units completed" value="96" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="available" label="Available time (optional)" value="7.5" min="0" step="0.25" suffix="hours" />
        <x-calc.field name="demand" label="Demand in that time" value="100" min="0" step="1" />
    </div>

    <x-calc.result label="Cycle time" />

    <x-calc.options :examples="[
        'Shift of 96 units' => ['time' => 480, 'units' => 96, 'available' => 7.5, 'demand' => 100],
        'Support tickets' => ['time' => 2400, 'units' => 160, 'available' => 40, 'demand' => 150],
        'Fast line' => ['time' => 60, 'units' => 240, 'available' => '', 'demand' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'seconds' => ['label' => 'In seconds'],
            'throughput' => ['label' => 'Throughput'],
            'takt' => ['label' => 'Takt time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cycle time = time ÷ units</li>
            <li>takt = available time ÷ demand</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
