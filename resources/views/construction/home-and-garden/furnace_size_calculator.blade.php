<x-calc.page
    title="Furnace Size Calculator - SolveKit"
    description="Free furnace size calculator: furnace input and output in Btu/h from the heat loss and AFUE, with the size range ACCA Manual S allows."
    lede="Work out the furnace size for a heat loss."
    about="A furnace must deliver the design heat loss: output = load, input = output ÷ AFUE. ACCA Manual S allows furnace output from 100% to 140% of the heating load. Find the load with the Heat Loss Calculator."
    :calc="['engine' => 'con-hvac', 'tool' => 'heating_size', 'fields' => ['load', 'efficiency'], 'data' => ['max' => 1.4, 'label' => 'Furnace input']]"
    :how-to="[
        ['name' => 'Enter the heat loss', 'text' => 'From a heat loss calculation.'],
        ['name' => 'Enter the efficiency', 'text' => 'AFUE from the furnace label.'],
    ]"
    :faqs="[
        ['question' => 'What size furnace for 45,000 Btu/h?', 'answer' => 'About 47,000 Btu/h input at 96% AFUE; a 60,000 Btu/h input model is within the 140% limit.'],
        ['question' => 'What is AFUE?', 'answer' => 'Annual fuel utilization efficiency: the share of fuel energy delivered as heat.'],
        ['question' => 'Can a furnace be too big?', 'answer' => 'Yes; oversizing shortens cycles and can make rooms uneven.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="load" label="Design heat loss" value="45000" min="0" suffix="Btu/h" />
        <x-calc.field name="efficiency" label="AFUE" value="96" min="1" max="100" suffix="%" />
    </div>

    <x-calc.result label="Furnace input" />

    <x-calc.options :examples="[
        '45,000 Btu/h at 96%' => ['load' => 45000, 'efficiency' => 96],
        '60,000 Btu/h at 80%' => ['load' => 60000, 'efficiency' => 80],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'output' => ['label' => 'Output'],
            'range' => ['label' => 'Allowed output'],
            'kw' => ['label' => 'Kilowatts'],
            'therms' => ['label' => 'Gas use'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>input = load ÷ AFUE</li>
            <li>output range = 100–140% of the load</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
