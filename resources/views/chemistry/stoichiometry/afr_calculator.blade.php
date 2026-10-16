<x-calc.page
    title="AFR Calculator (Air-Fuel Ratio) - SolveKit"
    description="Free air-fuel ratio calculator: stoichiometric AFR of any fuel from its formula, and lambda and equivalence ratio for a measured mixture."
    lede="Work out the stoichiometric air–fuel ratio of a fuel, or λ for a measured mixture."
    about="The stoichiometric AFR is the mass of dry air that supplies exactly enough oxygen to burn the fuel completely to CO₂, H₂O and SO₂. Dry air is taken as 20.946% oxygen by volume with a molar mass of 28.9644 g/mol (ISO 2533). Gasoline and diesel are blends that vary, typically about 14.7 and 14.5; enter a pure fuel's formula for an exact value."
    :calc="['engine' => 'chem-stoich', 'tool' => 'afr', 'fields' => ['mode', 'fuel', 'air', 'fuel_mass'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the fuel', 'text' => 'As a formula, e.g. C8H18 for octane.'],
        ['name' => 'For a mixture', 'text' => 'Enter the air and fuel mass to get λ.'],
    ]"
    :faqs="[
        ['question' => 'What is the AFR of octane?', 'answer' => 'About 15.1 : 1 by mass.'],
        ['question' => 'What is lambda?', 'answer' => 'Actual AFR ÷ stoichiometric AFR: above 1 is lean, below 1 is rich.'],
        ['question' => 'Why is ethanol\'s AFR so low?', 'answer' => 'It already contains oxygen, so it needs less air: about 9.0 : 1.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['stoich' => 'Stoichiometric AFR', 'measured' => 'λ for a mixture']" selected="stoich" />

    <x-calc.field name="fuel" label="Fuel formula" value="C8H18" type="text" help="e.g. CH4, C3H8, C8H18, C2H5OH, H2" />

    <div data-show-when="mode:measured" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="air" label="Air mass" value="16" min="0" />
            <x-calc.field name="fuel_mass" label="Fuel mass" value="1" min="0" help="Same unit as air" />
        </div>
    </div>

    <x-calc.result label="Air–fuel ratio" />

    <x-calc.options :examples="[
        'Octane' => ['mode' => 'stoich', 'fuel' => 'C8H18'],
        'Methane' => ['mode' => 'stoich', 'fuel' => 'CH4'],
        'Ethanol' => ['mode' => 'stoich', 'fuel' => 'C2H5OH'],
        'Lean octane mix' => ['mode' => 'measured', 'fuel' => 'C8H18', 'air' => 16, 'fuel_mass' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'stoich' => ['label' => 'Stoichiometric AFR'],
            'lambda' => ['label' => 'Lambda (λ)'],
            'phi' => ['label' => 'Equivalence ratio (φ)'],
            'oxygen' => ['label' => 'Oxygen needed'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>O₂ per mol fuel = C + H/4 + S − O/2</li>
            <li>AFR = O₂ × 28.9644 ÷ 0.20946 ÷ M(fuel)</li>
            <li>λ = AFR ÷ AFR(stoich); φ = 1/λ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
