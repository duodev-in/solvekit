<x-calc.page
    title="Kaya Identity Calculator - SolveKit"
    description="Free Kaya identity calculator: CO₂ emissions from population, GDP per person, energy intensity and carbon intensity, and how much each change drives the total."
    lede="Work out emissions with the Kaya identity, and what drives a change."
    about="The Kaya identity multiplies four factors: CO₂ = population × GDP per person × energy per unit of GDP × CO₂ per unit of energy. It is exact by construction. With percentage changes for each factor, the logarithmic (LMDI) split shows how much of the change in emissions each factor causes."
    :calc="['engine' => 'eco-footprint', 'tool' => 'kaya', 'fields' => ['population', 'gdp', 'energy', 'carbon', 'd_population', 'd_gdp', 'd_energy', 'd_carbon']]"
    :how-to="[
        ['name' => 'Enter the four factors', 'text' => 'For a country, region or the world.'],
        ['name' => 'Add changes', 'text' => 'To see the new total and what drives it.'],
    ]"
    :faqs="[
        ['question' => 'What is the Kaya identity?', 'answer' => 'A way to split emissions into population, affluence, energy intensity and carbon intensity.'],
        ['question' => 'Is it a model?', 'answer' => 'No, it is an identity: the four factors multiply out exactly.'],
        ['question' => 'How do emissions fall while GDP grows?', 'answer' => 'When energy intensity and carbon intensity fall faster than GDP rises.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="population" label="Population" value="8100000000.0" min="0" step="1" />
        <x-calc.field name="gdp" label="GDP per person" value="13000" min="0" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="energy" label="Energy per GDP" value="1.6" min="0" step="0.01" suffix="kWh per $" />
        <x-calc.field name="carbon" label="CO₂ per energy" value="0.23" min="0" step="0.001" suffix="kg per kWh" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="d_population" label="Population change" value="" suffix="%" placeholder="0" />
        <x-calc.field name="d_gdp" label="GDP per person change" value="" suffix="%" placeholder="0" />
        <x-calc.field name="d_energy" label="Energy intensity change" value="" suffix="%" placeholder="0" />
        <x-calc.field name="d_carbon" label="Carbon intensity change" value="" suffix="%" placeholder="0" />
    </div>

    <x-calc.result label="Emissions from the Kaya identity" />

    <x-calc.options :examples="[
        'Rounded world figures' => ['population' => 8100000000.0, 'gdp' => 13000, 'energy' => 1.6, 'carbon' => 0.23, 'd_population' => '', 'd_gdp' => '', 'd_energy' => '', 'd_carbon' => ''],
        'Growth with cleaner energy' => ['population' => 8100000000.0, 'gdp' => 13000, 'energy' => 1.6, 'carbon' => 0.23, 'd_population' => 1, 'd_gdp' => 3, 'd_energy' => -2, 'd_carbon' => -3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'per_person' => ['label' => 'Per person'],
            'energy' => ['label' => 'Energy use'],
            'change' => ['label' => 'After the changes'],
        ]" />
        <x-calc.quick-ref heading="What drives the change" name="factors" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CO₂ = P × (GDP ÷ P) × (E ÷ GDP) × (CO₂ ÷ E)</li>
            <li>share of change = ln(1 + xᵢ) ÷ Σ ln(1 + x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
