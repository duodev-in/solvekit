<x-calc.page
    title="Combustion Reaction Calculator - SolveKit"
    description="Free combustion reaction calculator: balanced complete combustion equation of any fuel, with oxygen and air needed."
    lede="Write and balance the complete combustion of a fuel."
    about="Complete combustion turns carbon into CO₂, hydrogen into H₂O, sulfur into SO₂ and nitrogen into N₂. The equation is balanced exactly, and the oxygen and air needed per gram of fuel follow."
    :calc="['engine' => 'chem-organic', 'tool' => 'combustion_reaction', 'fields' => ['fuel'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the fuel', 'text' => 'As a formula.'],
    ]"
    :faqs="[
        ['question' => 'What is complete combustion?', 'answer' => 'Burning with enough oxygen to give only CO₂ and H₂O.'],
        ['question' => 'How much oxygen does propane need?', 'answer' => '5 mol per mol.'],
        ['question' => 'What is incomplete combustion?', 'answer' => 'Too little oxygen gives CO and soot, which this tool does not model.'],
    ]"
>
    <x-calc.field name="fuel" label="Fuel formula" value="C3H8" type="text" help="C, H, O, N and S only, e.g. C8H18, C2H5OH" />

    <x-calc.result label="Combustion equation" />

    <x-calc.options :decimals="false" :examples="[
        'Propane' => ['fuel' => 'C3H8'],
        'Octane' => ['fuel' => 'C8H18'],
        'Ethanol' => ['fuel' => 'C2H5OH'],
        'Glucose' => ['fuel' => 'C6H12O6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'oxygen' => ['label' => 'Oxygen needed'],
            'products' => ['label' => 'Products per mole'],
            'air' => ['label' => 'Air needed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CₓHᵧOz + (x + y/4 − z/2) O₂ → x CO₂ + y/2 H₂O</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
