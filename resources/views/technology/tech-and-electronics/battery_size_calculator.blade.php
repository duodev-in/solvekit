<x-calc.page
    title="Battery Size Calculator - SolveKit"
    description="Free battery size calculator: battery bank capacity for a load, backup hours, voltage and battery type, with the number of batteries."
    lede="Size a battery bank."
    about="A battery bank must store the energy you use plus what it cannot deliver: lead-acid should only be half emptied, lithium most of the way."
    :calc="['engine' => 'tc-elec', 'tool' => 'battery_size', 'fields' => ['load', 'hours', 'v', 'chem', 'eff', 'unit', 'unitV'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What battery runs 300 W for 8 hours at 24 V (LiFePO4)?', 'answer' => '123.46 Ah at 24 V.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="load" label="Average load (W)" value="300" min="0" step="any" />
        <x-calc.field name="hours" label="Hours of backup (autonomy)" value="8" min="0" step="any" />
        <x-calc.field name="v" label="System voltage (V)" value="24" min="0" step="any" />
        <x-calc.select name="chem" label="Battery type" :options="['lfp' => 'LiFePO4 (90% usable)', 'nmc' => 'Lithium-ion NMC (80% usable)', 'agm' => 'Lead-acid AGM/gel (50% usable)', 'flooded' => 'Flooded lead-acid (50% usable)']" selected="lfp" />
        <x-calc.field name="eff" label="Inverter / system efficiency (%)" value="90" min="1" step="any" />
        <x-calc.field name="unit" label="Capacity of one battery (Ah, optional)" value="100" min="0" step="any" />
        <x-calc.field name="unitV" label="Voltage of one battery (V, optional)" value="12" min="0" step="any" />
    </div>

    <x-calc.result label="Battery capacity needed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['load' => 300, 'hours' => 8, 'v' => 24, 'chem' => 'lfp', 'eff' => 90, 'unit' => 100, 'unitV' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'wh' => ['label' => 'Energy to store'],
            'usableWh' => ['label' => 'Energy used'],
            'layout' => ['label' => 'Batteries needed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
