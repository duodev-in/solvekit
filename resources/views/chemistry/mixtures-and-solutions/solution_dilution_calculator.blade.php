<x-calc.page
    title="Solution Dilution Calculator - SolveKit"
    description="Free dilution calculator: solve C1V1 = C2V2 for stock volume, final volume or either concentration."
    lede="Solve C₁V₁ = C₂V₂ for any one of the four values."
    about="Diluting keeps the amount of solute the same, so concentration × volume is the same before and after. Use matching units on both sides, e.g. mM and mM, mL and mL."
    :calc="['engine' => 'lab', 'tool' => 'dilution', 'fields' => ['solve', 'c1', 'v1', 'c2', 'v2']]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'Usually the stock volume V₁.'],
        ['name' => 'Enter the other three', 'text' => 'Use the same units for both concentrations and both volumes.'],
        ['name' => 'Read the recipe', 'text' => 'Take V₁ of stock and add diluent up to V₂.'],
    ]"
    :faqs="[
        ['question' => 'How do I make a 1:10 dilution?', 'answer' => 'Take 1 part stock and add 9 parts diluent, e.g. 10 mL into 90 mL.'],
        ['question' => 'Can I mix units?', 'answer' => 'No: both concentrations must use the same unit, and both volumes the same unit.'],
        ['question' => 'Why can\'t C₂ be higher than C₁?', 'answer' => 'Dilution only lowers the concentration.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['v1' => 'Stock volume V₁', 'c1' => 'Stock concentration C₁', 'c2' => 'Final concentration C₂', 'v2' => 'Final volume V₂']" selected="v1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:v1,c2,v2">
            <x-calc.field name="c1" label="Stock concentration C₁ (any unit)" value="10" min="0" />
        </div>
        <div data-show-when="solve:c1,c2,v2" hidden>
            <x-calc.field name="v1" label="Stock volume V₁ (any unit)" value="10" min="0" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:c1,v1,v2">
            <x-calc.field name="c2" label="Final concentration C₂ (any unit)" value="1" min="0" />
        </div>
        <div data-show-when="solve:c1,v1,c2">
            <x-calc.field name="v2" label="Final volume V₂ (any unit)" value="100" min="0" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        '10× buffer to 1×, 100 mL' => ['solve' => 'v1', 'c1' => 10, 'c2' => 1, 'v2' => 100],
        '70% ethanol from 95%' => ['solve' => 'v1', 'c1' => 95, 'c2' => 70, 'v2' => 500],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'diluent' => ['label' => 'Diluent to add'],
            'factor' => ['label' => 'Dilution factor'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>C₁ × V₁ = C₂ × V₂</li>
            <li>diluent = V₂ − V₁</li>
            <li>dilution factor = C₁ ÷ C₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
