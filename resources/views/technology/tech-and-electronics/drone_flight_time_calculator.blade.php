<x-calc.page
    title="Drone Flight Time Calculator - SolveKit"
    description="Free drone flight time calculator: flight minutes from battery capacity, cells and average current or power."
    lede="Estimate drone flight time."
    about="Flight time is the usable battery charge divided by the average current the motors draw."
    :calc="['engine' => 'tc-elec', 'tool' => 'drone_flight', 'fields' => ['mah', 'cells', 'usable', 'by', 'amps', 'watts'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long does a 5000 mAh 4S battery last at 18 A?', 'answer' => 'About 13.33 min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="mah" label="Battery capacity (mAh)" value="5000" min="0" step="any" />
        <x-calc.field name="cells" label="Cells in series (S)" value="4" min="1" step="any" />
        <x-calc.field name="usable" label="Usable capacity (%)" value="80" min="1" step="any" />
        <x-calc.select name="by" label="Average draw from" :options="['amps' => 'Current (A)', 'watts' => 'Power (W)']" selected="amps" />
        <div data-show-when="by:amps">
            <x-calc.field name="amps" label="Average current (A)" value="18" min="0" step="any" />
        </div>
        <div data-show-when="by:watts">
            <x-calc.field name="watts" label="Average power (W)" value="266" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Flight time (estimate)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mah' => 5000, 'cells' => 4, 'usable' => 80, 'by' => 'amps', 'amps' => 18, 'watts' => 266],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'voltage' => ['label' => 'Nominal voltage'],
            'energy' => ['label' => 'Battery energy'],
            'current' => ['label' => 'Average current'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
