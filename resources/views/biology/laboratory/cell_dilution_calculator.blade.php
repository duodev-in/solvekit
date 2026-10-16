<x-calc.page
    title="Cell Dilution Calculator - SolveKit"
    description="Free cell dilution calculator: volume of cell suspension and medium to seed at a target cell density."
    lede="Work out how much cell suspension and medium to mix for a target cell density."
    about="Seeding cells is a C₁V₁ = C₂V₂ dilution with cells per mL as the concentration. Count the stock first, then take V₁ of it and add medium up to the final volume."
    :calc="['engine' => 'lab', 'tool' => 'dilution', 'fields' => ['solve', 'c1', 'v1', 'c2', 'v2'], 'data' => ['concentration' => 'cells/mL', 'volume' => 'mL']]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'Usually the stock volume V₁.'],
        ['name' => 'Enter the other three', 'text' => 'Use the same units for both concentrations and both volumes.'],
        ['name' => 'Read the recipe', 'text' => 'Take V₁ of stock and add diluent up to V₂.'],
    ]"
    :faqs="[
        ['question' => 'How many cells do I need for a 6-well plate?', 'answer' => 'Typically 1 to 3 × 10⁵ cells per well in 2 mL, depending on the cell line.'],
        ['question' => 'Should I count viable cells only?', 'answer' => 'Yes, use the viable cell density from a trypan blue count.'],
        ['question' => 'What if V₁ is very small?', 'answer' => 'Make an intermediate dilution first so you are not pipetting under about 2 µL.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['v1' => 'Stock volume V₁', 'c1' => 'Stock concentration C₁', 'c2' => 'Final concentration C₂', 'v2' => 'Final volume V₂']" selected="v1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:v1,c2,v2">
            <x-calc.field name="c1" label="Stock concentration C₁ (cells/mL)" value="1000000" min="0" />
        </div>
        <div data-show-when="solve:c1,c2,v2" hidden>
            <x-calc.field name="v1" label="Stock volume V₁ (mL)" value="2" min="0" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:c1,v1,v2">
            <x-calc.field name="c2" label="Final concentration C₂ (cells/mL)" value="200000" min="0" />
        </div>
        <div data-show-when="solve:c1,v1,c2">
            <x-calc.field name="v2" label="Final volume V₂ (mL)" value="10" min="0" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Seed 2 × 10⁵ /mL in 10 mL' => ['solve' => 'v1', 'c1' => 1000000, 'c2' => 200000, 'v2' => 10],
        '5 × 10⁴ /mL in 25 mL' => ['solve' => 'v1', 'c1' => 2500000, 'c2' => 50000, 'v2' => 25],
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
