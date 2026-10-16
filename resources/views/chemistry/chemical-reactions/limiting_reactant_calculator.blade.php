<x-calc.page
    title="Limiting Reactant Calculator - SolveKit"
    description="Free limiting reactant calculator: which reactant runs out first, how much of each is left over, and the products formed."
    lede="Find the limiting reactant and what is left over."
    about="Each reactant's moles are divided by its coefficient in the balanced equation; the smallest value is the limiting reactant. The others are in excess, and the left-over amounts and the products formed follow from that."
    :calc="['engine' => 'chem-reactions', 'tool' => 'limiting_reactant', 'fields' => ['equation', 'amounts'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the equation', 'text' => 'It is balanced for you.'],
        ['name' => 'Enter two or more reactants', 'text' => 'Formula and amount, one per line.'],
    ]"
    :faqs="[
        ['question' => 'How do I find the limiting reactant?', 'answer' => 'Divide each reactant\'s moles by its coefficient; the smallest is limiting.'],
        ['question' => 'Is the limiting reactant the one with the smallest mass?', 'answer' => 'Not necessarily: molar mass and coefficients matter.'],
        ['question' => 'What is the excess reactant?', 'answer' => 'Any reactant left over when the limiting one is used up.'],
    ]"
>
    <x-calc.field name="equation" label="Chemical equation" value="Fe2O3 + CO = Fe + CO2" type="text" help="Use = or ->; it is balanced for you" />

    <x-calc.textarea name="amounts" label="Reactant amounts" value="Fe2O3 100 g
CO 60 g" help="One per line: formula, amount and unit (g, mg, kg or mol)" rows="3" />

    <x-calc.result label="Limiting reactant" />

    <x-calc.options :examples="[
        'Iron ore and CO' => ['equation' => 'Fe2O3 + CO = Fe + CO2', 'amounts' => 'Fe2O3 100 g
CO 60 g'],
        'Hydrogen and oxygen' => ['equation' => 'H2 + O2 = H2O', 'amounts' => 'H2 10 g
O2 64 g'],
        'Haber process' => ['equation' => 'N2 + H2 = NH3', 'amounts' => 'N2 2 mol
H2 5 mol'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'equation' => ['label' => 'Balanced equation'],
            'products' => ['label' => 'Products formed'],
        ]" />
        <x-calc.quick-ref heading="Left over" name="left" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>limiting = smallest n ÷ ν</li>
            <li>left over = n − ν × extent</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
