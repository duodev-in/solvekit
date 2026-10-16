<x-calc.page
    title="Dilution Factor Calculator - SolveKit"
    description="Free dilution factor calculator: dilution factor from volumes or concentrations, and the aliquot and diluent for a chosen factor."
    lede="Work out a dilution factor, or the volumes for one."
    about="The dilution factor is final volume ÷ aliquot volume, the same as stock concentration ÷ final concentration. “1:10” here means 1 part in 10 total; some labs use it for 1 part plus 10 parts, so check which your protocol means."
    :calc="['engine' => 'chem-mix', 'tool' => 'dilution_factor', 'fields' => ['mode', 'aliquot', 'c1', 'c2', 'factor', 'final']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Volumes, concentrations or the factor.'],
        ['name' => 'Enter the final volume', 'text' => 'For the aliquot and diluent.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate a dilution factor?', 'answer' => 'Final volume ÷ volume of sample taken.'],
        ['question' => 'What does 1:10 mean?', 'answer' => 'Usually 1 part sample in 10 parts total.'],
        ['question' => 'How do factors combine?', 'answer' => 'They multiply: two 1:10 steps make 1:100.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['volumes' => 'Volumes', 'concentrations' => 'Concentrations', 'factor' => 'Factor']" selected="volumes" />

    <div data-show-when="mode:volumes">
        <x-calc.field name="aliquot" label="Aliquot volume" value="1" min="0" suffix="mL" />
    </div>

    <div data-show-when="mode:concentrations" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="c1" label="Stock concentration" value="100" min="0" />
            <x-calc.field name="c2" label="Final concentration" value="5" min="0" />
        </div>
    </div>

    <div data-show-when="mode:factor" hidden>
        <x-calc.field name="factor" label="Dilution factor" value="20" min="1" />
    </div>

    <x-calc.field name="final" label="Final volume" value="10" min="0" suffix="mL" />

    <x-calc.result label="Dilution factor" />

    <x-calc.options :examples="[
        '1 mL to 10 mL' => ['mode' => 'volumes', 'aliquot' => 1, 'final' => 10],
        '100 to 5 in 50 mL' => ['mode' => 'concentrations', 'c1' => 100, 'c2' => 5, 'final' => 50],
        '1:20 in 200 mL' => ['mode' => 'factor', 'factor' => 20, 'final' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'aliquot' => ['label' => 'Aliquot'],
            'diluent' => ['label' => 'Diluent to add'],
            'log' => ['label' => 'In log units'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DF = V final ÷ V aliquot = C stock ÷ C final</li>
            <li>diluent = V final − V aliquot</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
