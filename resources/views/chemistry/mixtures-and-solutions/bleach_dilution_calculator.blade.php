<x-calc.page
    title="Bleach Dilution Calculator - SolveKit"
    description="Free bleach dilution calculator: how much household bleach to add to water for a target ppm of sodium hypochlorite."
    lede="Work out how much bleach to mix with water for a target strength."
    about="The label gives the sodium hypochlorite percent by mass. The bleach needed is the target mass (ppm × liters = mg) divided by the bleach's concentration, using its density from the safety data sheet. Follow the product label for disinfection times and safety; never mix bleach with ammonia or acids."
    :calc="['engine' => 'chem-mix', 'tool' => 'bleach', 'fields' => ['percent', 'target', 'volume', 'density']]"
    :how-to="[
        ['name' => 'Read the label', 'text' => 'Sodium hypochlorite percent.'],
        ['name' => 'Choose the target ppm', 'text' => 'From the instructions you are following.'],
        ['name' => 'Enter the volume', 'text' => 'The total you will make.'],
    ]"
    :faqs="[
        ['question' => 'What is ppm for bleach?', 'answer' => 'Milligrams of sodium hypochlorite per liter of solution.'],
        ['question' => 'What is available chlorine?', 'answer' => 'The same amount expressed as Cl₂: 0.952 × the sodium hypochlorite figure.'],
        ['question' => 'Does bleach lose strength?', 'answer' => 'Yes, over months and faster when warm, so the real strength may be lower than the label.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="percent" label="Sodium hypochlorite" value="6" min="0" suffix="%" help="From the label" />
        <x-calc.field name="target" label="Target" value="200" min="0" suffix="ppm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="volume" label="Final volume" value="1" min="0" suffix="L" />
        <x-calc.field name="density" label="Bleach density" value="1.08" min="0" suffix="g/mL" help="From the SDS; about 1.08 for 6% bleach" />
    </div>

    <x-calc.result label="Bleach to add" />

    <x-calc.options :examples="[
        '200 ppm in 1 L (6%)' => ['percent' => 6, 'target' => 200, 'volume' => 1, 'density' => 1.08],
        '1000 ppm in 5 L (8.25%)' => ['percent' => 8.25, 'target' => 1000, 'volume' => 5, 'density' => 1.1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'water' => ['label' => 'Water to add'],
            'ratio' => ['label' => 'Ratio'],
            'chlorine' => ['label' => 'As available chlorine'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mg needed = ppm × liters</li>
            <li>mL bleach = mg ÷ (% ÷ 100) ÷ density ÷ 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
