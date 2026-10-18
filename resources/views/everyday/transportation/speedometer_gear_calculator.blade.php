<x-calc.page
    title="Speedometer Gear Calculator - SolveKit"
    description="Free speedometer gear calculator: driven gear teeth for a cable-driven speedometer after changing tires or axle ratio, and the remaining error."
    lede="Choose the speedometer driven gear after changing tires or gears."
    about="Cable speedometers are built to turn 1,001 times per mile. Driven gear teeth = tire revolutions per mile × axle ratio × drive gear teeth ÷ 1,001 (the GM formula). Gears come in whole teeth, so the nearest gear leaves a small error, shown here."
    :calc="['engine' => 'ev-transport', 'tool' => 'speedo_gear', 'fields' => ['revs', 'axle', 'drive']]"
    :how-to="[
        ['name' => 'Enter the tire revs per mile', 'text' => 'From the tire maker or Tire Size calculator.'],
        ['name' => 'Enter axle ratio and drive gear', 'text' => 'Count the drive gear teeth in the transmission.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate the speedometer gear?', 'answer' => 'Revs per mile × axle ratio × drive teeth ÷ 1,001.'],
        ['question' => 'What for 672 revs, 4.10 and 8 teeth?', 'answer' => '22 teeth (22.02 exact).'],
        ['question' => 'What if no gear fits?', 'answer' => 'Use an inline ratio adapter.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="revs" label="Tire revolutions per mile" value="672" min="1" step="1" />
        <x-calc.field name="axle" label="Axle ratio" value="4.1" min="0.5" step="0.01" suffix=":1" />
        <x-calc.field name="drive" label="Drive gear teeth" value="8" min="1" step="1" />
    </div>

    <x-calc.result label="Driven gear" />

    <x-calc.options :examples="[
        '672 revs, 4.10, 8 teeth' => ['revs' => 672, 'axle' => 4.1, 'drive' => 8],
        'Bigger tires, 3.73' => ['revs' => 620, 'axle' => 3.73, 'drive' => 7],
        'Stock 3.08' => ['revs' => 760, 'axle' => 3.08, 'drive' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'error' => ['label' => 'Error'],
            'cable' => ['label' => 'Basis'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>teeth = revs/mile × axle × drive ÷ 1,001</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
