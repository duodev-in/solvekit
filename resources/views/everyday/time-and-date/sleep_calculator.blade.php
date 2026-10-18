<x-calc.page
    title="Sleep Calculator - SolveKit"
    description="Free sleep calculator: the best times to go to bed or wake up so you wake between 90-minute sleep cycles, allowing time to fall asleep."
    lede="Find a bedtime or wake-up time that fits whole sleep cycles."
    about="Sleep runs in cycles of roughly 90 minutes (they vary from about 70 to 120). Waking at the end of a cycle, rather than in deep sleep, is said to feel easier. The times here add your minutes to fall asleep to whole cycles. Adults need at least 7 hours a night (American Academy of Sleep Medicine and Sleep Research Society); the suggested time is the number of whole cycles closest to 8 hours."
    :calc="['engine' => 'ev-time', 'tool' => 'sleep', 'fields' => ['mode', 'time', 'latency', 'cycle']]"
    :how-to="[
        ['name' => 'Choose wake or bed', 'text' => 'And enter the time.'],
        ['name' => 'Adjust if needed', 'text' => 'How long you take to fall asleep.'],
    ]"
    :faqs="[
        ['question' => 'What time should I go to bed to wake at 6:30?', 'answer' => '10:45 PM (5 cycles, 7.5 hours) or 9:15 PM (6 cycles, 9 hours), allowing 15 minutes to fall asleep.'],
        ['question' => 'How long is a sleep cycle?', 'answer' => 'About 90 minutes on average.'],
        ['question' => 'How much sleep do adults need?', 'answer' => '7 or more hours a night.'],
    ]"
>
    <x-calc.segmented name="mode" legend="I want to" :options="['wake' => 'Wake up at', 'bed' => 'Go to bed at']" selected="wake" />

    <x-calc.field name="time" label="Time" value="06:30" type="time" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="latency" label="Minutes to fall asleep" value="15" min="0" max="120" step="1" />
        <x-calc.field name="cycle" label="Cycle length" value="90" min="60" max="120" step="5" suffix="min" />
    </div>

    <x-calc.result label="Go to bed at" />

    <x-calc.options :decimals="false" :examples="[
        'Wake at 6:30' => ['mode' => 'wake', 'time' => '06:30', 'latency' => 15, 'cycle' => 90],
        'Bed at 23:00' => ['mode' => 'bed', 'time' => '23:00', 'latency' => 15, 'cycle' => 90],
        'Wake at 7:45, slow to sleep' => ['mode' => 'wake', 'time' => '07:45', 'latency' => 30, 'cycle' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'range' => ['label' => 'How much sleep'],
            'cycle' => ['label' => 'Sleep cycles'],
        ]" />
        <x-calc.quick-ref heading="Options" name="options" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bedtime = wake time − cycles × 90 min − minutes to fall asleep</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
