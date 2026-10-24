<x-calc.page
    title="Battery Capacity Calculator - SolveKit"
    description="Free battery capacity calculator: convert Ah to Wh and back, with run time for a load."
    lede="Convert battery Ah and Wh."
    about="Battery capacity in amp-hours tells the charge; watt-hours tell the energy, which also depends on the voltage."
    :calc="['engine' => 'tc-elec', 'tool' => 'battery_capacity', 'fields' => ['mode', 'v', 'ah', 'wh', 'load'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many Wh is a 12 V, 100 Ah battery?', 'answer' => '1,200 Wh.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['wh' => 'Energy (Wh) from Ah and volts', 'ah' => 'Capacity (Ah) from Wh and volts']" selected="wh" />
        <x-calc.field name="v" label="Voltage (V)" value="12" min="0" step="any" />
        <div data-show-when="mode:wh">
            <x-calc.field name="ah" label="Capacity (Ah)" value="100" min="0" step="any" />
        </div>
        <div data-show-when="mode:ah">
            <x-calc.field name="wh" label="Energy (Wh)" value="1200" min="0" step="any" />
        </div>
        <x-calc.field name="load" label="Load (W, optional)" value="60" min="0" step="any" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'wh', 'v' => 12, 'ah' => 100, 'wh' => 1200, 'load' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mah' => ['label' => 'In mAh'],
            'kwh' => ['label' => 'In kWh'],
            'runtime' => ['label' => 'Run time at the load (ideal)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
