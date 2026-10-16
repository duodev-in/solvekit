<x-calc.page
    title="Hemocytometer Cell Count Calculator - SolveKit"
    description="Free hemocytometer calculator: cells per mL, viable cells and viability from a counting chamber and trypan blue."
    lede="Turn hemocytometer counts into cells per mL and viability."
    about="Each large square of a standard (Neubauer) hemocytometer holds 0.1 µL, so the mean count per square × 10⁴ is the cells per mL. Multiply by the dilution, e.g. 2 for a 1:1 mix with trypan blue."
    :calc="['engine' => 'lab', 'tool' => 'hemocytometer', 'fields' => ['count', 'squares', 'dilution', 'dead', 'volume']]"
    :how-to="[
        ['name' => 'Count the squares', 'text' => 'Count all cells in the large corner squares.'],
        ['name' => 'Enter dead cells', 'text' => 'Blue cells after trypan blue, out of the same count.'],
        ['name' => 'Enter the dilution', 'text' => 'The dilution before loading the chamber.'],
    ]"
    :faqs="[
        ['question' => 'Why multiply by 10,000?', 'answer' => 'A large square is 1 mm × 1 mm × 0.1 mm = 0.1 µL, and 1 mL is 10,000 of those.'],
        ['question' => 'How many cells should I count?', 'answer' => 'Aim for 100 to 300 cells in total for a reliable count.'],
        ['question' => 'What is good viability?', 'answer' => 'Above 90% for a healthy culture in log phase.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="count" label="Total cells counted" value="200" min="0" step="1" />
        <x-calc.field name="squares" label="Large squares counted" value="4" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dilution" label="Dilution factor" value="2" min="0" help="2 for 1:1 with trypan blue" />
        <x-calc.field name="dead" label="Dead (blue) cells among them" value="10" min="0" step="1" />
    </div>

    <x-calc.field name="volume" label="Sample volume (optional)" value="10" min="0" suffix="mL" placeholder="Optional" />

    <x-calc.result label="Cells per mL" />

    <x-calc.options :examples="[
        '4 squares, 1:1 trypan' => ['count' => 200, 'squares' => 4, 'dilution' => 2, 'dead' => 10],
        'Dense culture 1:10' => ['count' => 320, 'squares' => 4, 'dilution' => 10, 'dead' => 40],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'viable' => ['label' => 'Viable cells per mL'],
            'viability' => ['label' => 'Viability'],
            'total' => ['label' => 'Total cells in sample'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cells/mL = (count ÷ squares) × dilution × 10⁴</li>
            <li>viability = (count − dead) ÷ count</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
