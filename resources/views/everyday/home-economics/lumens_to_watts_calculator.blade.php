<x-calc.page
    title="Lumens to Watts Calculator - SolveKit"
    description="Free lumens to watts calculator: watts needed for a light output by bulb type (LED, CFL, halogen, incandescent), and the equivalent incandescent bulb."
    lede="Convert between lumens and watts for any bulb type."
    about="Watts = lumens ÷ luminous efficacy (lumens per watt). Typical efficacies, from standard 800-lumen bulbs: incandescent 13.3 lm/W (60 W), halogen 18.6 (43 W), CFL 61.5 (13 W) and LED 88.9 (9 W). ENERGY STAR equates 450, 800, 1,100, 1,600 and 2,600 lumens with 40, 60, 75, 100 and 150 W incandescent bulbs. Enter your bulb's own efficacy for an exact answer."
    :calc="['engine' => 'ev-home', 'tool' => 'lumens_watts', 'fields' => ['direction', 'lumens', 'watts', 'bulb', 'efficacy'], 'data' => ['lumens' => config('everyday_data.lumens')]]"
    :how-to="[
        ['name' => 'Choose the direction', 'text' => 'Lumens to watts or back.'],
        ['name' => 'Pick the bulb type', 'text' => 'Or enter its lm/W.'],
    ]"
    :faqs="[
        ['question' => 'How many watts is 800 lumens?', 'answer' => 'About 9 W LED, 13 W CFL or 60 W incandescent.'],
        ['question' => 'How many lumens is a 100 W bulb?', 'answer' => 'About 1,600.'],
        ['question' => 'What is a good LED efficacy?', 'answer' => 'Many LEDs give 80–120 lm/W.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['to_watts' => 'Lumens → watts', 'to_lumens' => 'Watts → lumens']" selected="to_watts" />

    <div data-show-when="direction:to_watts">
        <x-calc.field name="lumens" label="Lumens" value="800" min="0" />
    </div>

    <div data-show-when="direction:to_lumens" hidden>
        <x-calc.field name="watts" label="Watts" value="9" min="0" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="bulb" label="Bulb type" :options="['led' => 'LED (88.9 lm/W)', 'cfl' => 'CFL (61.5 lm/W)', 'halogen' => 'Halogen (18.6 lm/W)', 'incandescent' => 'Incandescent (13.3 lm/W)']" selected="led" />
        <x-calc.field name="efficacy" label="Your efficacy (optional)" value="" min="0" suffix="lm/W" />
    </div>

    <x-calc.result label="Power needed" />

    <x-calc.options :examples="[
        '800 lumens LED' => ['direction' => 'to_watts', 'lumens' => 800, 'watts' => '', 'bulb' => 'led', 'efficacy' => ''],
        '1,600 lumens halogen' => ['direction' => 'to_watts', 'lumens' => 1600, 'watts' => '', 'bulb' => 'halogen', 'efficacy' => ''],
        '12 W LED at 110 lm/W' => ['direction' => 'to_lumens', 'lumens' => '', 'watts' => 12, 'bulb' => 'led', 'efficacy' => 110],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'equivalent' => ['label' => 'Equivalent'],
            'led' => ['label' => 'By type'],
        ]" />
        <x-calc.quick-ref heading="ENERGY STAR equivalents" name="equivalence" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>W = lm ÷ (lm/W)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
