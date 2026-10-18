<x-calc.page
    title="Boiler Size Calculator - SolveKit"
    description="Free boiler size calculator: boiler output and input from the heat loss, efficiency and any domestic hot water load."
    lede="Work out the boiler size for a heat loss."
    about="A boiler's output must cover the design heat loss, plus any domestic hot water it also heats; input = output ÷ efficiency. Find the heat loss with the Heat Loss Calculator; for a combi or indirect water heater, add the hot water load the maker gives."
    :calc="['engine' => 'con-hvac', 'tool' => 'heating_size', 'fields' => ['load', 'efficiency', 'dhw'], 'data' => ['max' => 1.4, 'label' => 'Boiler input']]"
    :how-to="[
        ['name' => 'Enter the heat loss', 'text' => 'From a heat loss calculation.'],
        ['name' => 'Add hot water', 'text' => 'If the boiler also heats water.'],
    ]"
    :faqs="[
        ['question' => 'What size boiler for 60,000 Btu/h?', 'answer' => 'About 66,700 Btu/h input at 90% efficiency.'],
        ['question' => 'How many kW is 60,000 Btu/h?', 'answer' => 'About 17.6 kW.'],
        ['question' => 'Do I add hot water?', 'answer' => 'Only if the boiler heats domestic water too.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="load" label="Design heat loss" value="60000" min="0" suffix="Btu/h" />
        <x-calc.field name="efficiency" label="Efficiency (AFUE)" value="90" min="1" max="100" suffix="%" />
        <x-calc.field name="dhw" label="Hot water load (optional)" value="" min="0" suffix="Btu/h" placeholder="0" />
    </div>

    <x-calc.result label="Boiler input" />

    <x-calc.options :examples="[
        '60,000 Btu/h at 90%' => ['load' => 60000, 'efficiency' => 90],
        'With hot water' => ['load' => 50000, 'efficiency' => 95, 'dhw' => 30000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'output' => ['label' => 'Output'],
            'range' => ['label' => 'Output range'],
            'kw' => ['label' => 'Kilowatts'],
            'therms' => ['label' => 'Gas use'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>output = load + hot water</li>
            <li>input = output ÷ efficiency</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
