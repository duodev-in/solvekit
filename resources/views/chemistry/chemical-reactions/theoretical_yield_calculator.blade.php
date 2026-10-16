<x-calc.page
    title="Theoretical Yield Calculator - SolveKit"
    description="Free theoretical yield calculator: maximum product mass from reactant amounts, with the limiting reactant and percent yield."
    lede="Work out the most product a reaction can give."
    about="The equation is balanced, each reactant's moles are divided by its coefficient, and the smallest result marks the limiting reactant. The theoretical yield is that amount times the product's coefficient and molar mass."
    :calc="['engine' => 'chem-reactions', 'tool' => 'theoretical_yield', 'fields' => ['equation', 'amounts', 'product', 'actual'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the equation', 'text' => 'It is balanced for you.'],
        ['name' => 'Enter the reactants', 'text' => 'Formula and amount, one per line.'],
        ['name' => 'Name the product', 'text' => 'And the actual yield if you have it.'],
    ]"
    :faqs="[
        ['question' => 'What is theoretical yield?', 'answer' => 'The product you would get if the limiting reactant reacted completely.'],
        ['question' => 'Why is actual yield lower?', 'answer' => 'Side reactions, losses in handling and incomplete reactions.'],
        ['question' => 'What if I give only one reactant?', 'answer' => 'It is taken as limiting; the others are assumed in excess.'],
    ]"
>
    <x-calc.field name="equation" label="Chemical equation" value="H2 + O2 = H2O" type="text" help="Use = or ->; it is balanced for you" />

    <x-calc.textarea name="amounts" label="Reactant amounts" value="H2 4 g
O2 32 g" help="One per line: formula, amount and unit (g, mg, kg or mol)" rows="3" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="product" label="Product" value="H2O" type="text" help="The product you want" />
        <x-calc.field name="actual" label="Actual yield (optional)" value="30" min="0" suffix="g" placeholder="Optional" />
    </div>

    <x-calc.result label="Theoretical yield" />

    <x-calc.options :examples="[
        'Water from H₂ and O₂' => ['equation' => 'H2 + O2 = H2O', 'amounts' => 'H2 4 g
O2 32 g', 'product' => 'H2O', 'actual' => 30],
        'Iron from Fe₂O₃' => ['equation' => 'Fe2O3 + CO = Fe + CO2', 'amounts' => 'Fe2O3 100 g
CO 60 g', 'product' => 'Fe', 'actual' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'moles' => ['label' => 'In moles'],
            'limiting' => ['label' => 'Limiting reactant'],
            'percent' => ['label' => 'Percent yield'],
        ]" />
        <x-calc.quick-ref heading="Reactants" name="reactants" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n ÷ coefficient for each reactant; smallest is limiting</li>
            <li>yield = (n ÷ ν)limiting × ν product × M product</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
