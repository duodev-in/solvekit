<x-calc.page
    title="MLVSS Calculator - SolveKit"
    description="Free MLVSS calculator: mixed liquor volatile suspended solids from MLSS and volatile fraction, in mg/L and pounds."
    lede="Work out MLVSS from MLSS and the volatile fraction."
    about="MLVSS is the organic (volatile) part of the mixed liquor suspended solids, roughly the active biomass. It is MLSS × volatile fraction, usually 65 to 85%. Pounds in a tank use the pounds formula: mg/L × million gallons × 8.34."
    :calc="['engine' => 'wastewater', 'tool' => 'mlvss', 'fields' => ['mlss', 'volatile', 'volume']]"
    :how-to="[
        ['name' => 'Enter MLSS and volatile %', 'text' => 'From the lab\'s total and volatile solids tests.'],
        ['name' => 'Enter the tank volume', 'text' => 'In million gallons, for pounds under aeration.'],
    ]"
    :faqs="[
        ['question' => 'What is a typical MLVSS/MLSS ratio?', 'answer' => 'About 0.65 to 0.85 for conventional activated sludge.'],
        ['question' => 'Why use MLVSS?', 'answer' => 'It approximates the living biomass used in the F/M ratio.'],
        ['question' => 'What is the 8.34?', 'answer' => 'The weight of one gallon of water in pounds.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="mlss" label="MLSS" value="3000" min="0" suffix="mg/L" />
        <x-calc.field name="volatile" label="Volatile fraction" value="75" min="0" max="100" suffix="%" />
        <x-calc.field name="volume" label="Aeration volume" value="1.2" min="0" step="0.01" suffix="MG" />
    </div>

    <x-calc.result label="MLVSS" />

    <x-calc.options :examples="[
        'Plant A' => ['mlss' => 2800, 'volatile' => 78, 'volume' => 1.2],
        'Plant B' => ['mlss' => 3500, 'volatile' => 70, 'volume' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'lb' => ['label' => 'MLVSS under aeration'],
            'kg' => ['label' => 'In kilograms'],
            'mlss_lb' => ['label' => 'MLSS under aeration'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MLVSS = MLSS × volatile fraction</li>
            <li>lb = mg/L × MG × 8.34</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
