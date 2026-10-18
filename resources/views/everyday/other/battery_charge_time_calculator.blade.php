<x-calc.page
    title="Battery Charge Time Calculator - SolveKit"
    description="Free battery charge time calculator: how long a battery takes to charge from its capacity in Ah or Wh, the charger's current or power, and charging efficiency."
    lede="Work out how long a battery takes to charge."
    about="Energy needed = capacity × (target % − starting %). Time = energy ÷ (charger power × efficiency). In amps and amp-hours with the same voltage, that is Ah ÷ (A × efficiency). Lead-acid charging is often 80–85% efficient, lithium 90–95%. Chargers slow down near full, so the real time can be longer."
    :calc="['engine' => 'ev-care', 'tool' => 'battery_charge', 'fields' => ['mode', 'ah', 'volts', 'wh', 'charger_mode', 'charger_a', 'charger_w', 'from', 'to', 'efficiency', 'price']]"
    :how-to="[
        ['name' => 'Enter the capacity', 'text' => 'Ah and voltage, or Wh.'],
        ['name' => 'Enter the charger and charge levels', 'text' => 'And efficiency.'],
    ]"
    :faqs="[
        ['question' => 'How long to charge a 100 Ah battery with a 10 A charger?', 'answer' => 'From 20%: about 9 h 25 min at 85% efficiency.'],
        ['question' => 'How long to charge a 75 Wh laptop battery with 30 W?', 'answer' => 'About 2 h 21 min from 20% at 85%.'],
        ['question' => 'Why is the last part slow?', 'answer' => 'Chargers lower the current near full to protect the battery.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Capacity in" :options="['ah' => 'Amp-hours', 'wh' => 'Watt-hours']" selected="ah" />

    <div data-show-when="mode:ah">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="ah" label="Capacity" value="100" min="0" suffix="Ah" />
            <x-calc.field name="volts" label="Battery voltage" value="12" min="0" step="0.1" suffix="V" />
        </div>
    </div>

    <div data-show-when="mode:wh" hidden>
        <x-calc.field name="wh" label="Capacity" value="75" min="0" suffix="Wh" />
    </div>

    <x-calc.segmented name="charger_mode" legend="Charger rated in" :options="['amps' => 'Amps', 'watts' => 'Watts']" selected="amps" />

    <div data-show-when="charger_mode:amps">
        <x-calc.field name="charger_a" label="Charging current" value="10" min="0" step="0.1" suffix="A" />
    </div>

    <div data-show-when="charger_mode:watts" hidden>
        <x-calc.field name="charger_w" label="Charging power" value="30" min="0" suffix="W" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="from" label="Starting charge" value="20" min="0" max="100" step="1" suffix="%" />
        <x-calc.field name="to" label="Target charge" value="100" min="1" max="100" step="1" suffix="%" />
        <x-calc.field name="efficiency" label="Efficiency" value="85" min="30" max="100" step="1" suffix="%" />
    </div>

    <x-calc.field name="price" label="Electricity price (optional)" value="" min="0" step="0.01" suffix="$" />

    <x-calc.result label="Charging time" />

    <x-calc.options :examples="[
        '100 Ah, 10 A' => ['mode' => 'ah', 'ah' => 100, 'volts' => 12, 'wh' => '', 'charger_mode' => 'amps', 'charger_a' => 10, 'charger_w' => '', 'from' => 20, 'to' => 100, 'efficiency' => 85, 'price' => ''],
        'Laptop 75 Wh, 30 W' => ['mode' => 'wh', 'ah' => '', 'volts' => '', 'wh' => 75, 'charger_mode' => 'watts', 'charger_a' => '', 'charger_w' => 30, 'from' => 20, 'to' => 100, 'efficiency' => 85, 'price' => ''],
        'Power station 1 kWh' => ['mode' => 'wh', 'ah' => '', 'volts' => '', 'wh' => 1024, 'charger_mode' => 'watts', 'charger_w' => 400, 'charger_a' => '', 'from' => 10, 'to' => 90, 'efficiency' => 92, 'price' => 0.17],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'energy' => ['label' => 'From the charger'],
            'cost' => ['label' => 'Cost'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>time = Wh × Δ% ÷ (W × efficiency)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
