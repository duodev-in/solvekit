<x-calc.page
    title="Enzyme Activity Calculator - SolveKit"
    description="Free enzyme activity calculator: units per mL and specific activity from a spectrophotometric rate."
    lede="Work out enzyme activity from an absorbance rate."
    about="The rate of absorbance change, divided by ε × path length, gives the concentration change per minute (Beer–Lambert). Multiplied by the assay volume it gives µmol per minute: 1 unit (U) converts 1 µmol of substrate per minute. Dividing by the enzyme volume and protein concentration gives U/mL and U/mg."
    :calc="['engine' => 'chem-biochem', 'tool' => 'enzyme_activity', 'fields' => ['rate', 'epsilon', 'path', 'total_volume', 'enzyme_volume', 'dilution', 'protein']]"
    :how-to="[
        ['name' => 'Measure the rate', 'text' => 'ΔA per minute in the linear part.'],
        ['name' => 'Enter ε and volumes', 'text' => 'Total assay and enzyme volume.'],
        ['name' => 'Add protein', 'text' => 'For specific activity.'],
    ]"
    :faqs="[
        ['question' => 'What is an enzyme unit?', 'answer' => 'The amount converting 1 µmol of substrate per minute.'],
        ['question' => 'What is a katal?', 'answer' => 'The SI unit: 1 mol per second; 1 U = 16.67 nkat.'],
        ['question' => 'What ε should I use for NADH?', 'answer' => '6220 M⁻¹cm⁻¹ at 340 nm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rate" label="ΔA per minute" value="0.1" />
        <x-calc.field name="epsilon" label="Molar absorptivity ε" value="6220" min="0" suffix="M⁻¹cm⁻¹" help="NADH at 340 nm: 6220" />
        <x-calc.field name="path" label="Path length" value="1" min="0" suffix="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="total_volume" label="Total assay volume" value="1" min="0" suffix="mL" />
        <x-calc.field name="enzyme_volume" label="Enzyme volume added" value="0.1" min="0" suffix="mL" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="dilution" label="Enzyme dilution factor" value="1" min="1" />
        <x-calc.field name="protein" label="Protein concentration (optional)" value="0.5" min="0" suffix="mg/mL" placeholder="Optional" />
    </div>

    <x-calc.result label="Enzyme activity" />

    <x-calc.options :examples="[
        'NADH assay' => ['rate' => 0.1, 'epsilon' => 6220, 'path' => 1, 'total_volume' => 1, 'enzyme_volume' => 0.1, 'dilution' => 1, 'protein' => 0.5],
        'Diluted lysate' => ['rate' => 0.045, 'epsilon' => 6220, 'path' => 1, 'total_volume' => 3, 'enzyme_volume' => 0.05, 'dilution' => 10, 'protein' => 2.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'specific' => ['label' => 'Specific activity'],
            'katal' => ['label' => 'In katal'],
            'cuvette' => ['label' => 'Rate in the cuvette'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>U/mL = ΔA/min ÷ (ε l) × V total × 10⁶ ÷ V enzyme × dilution</li>
            <li>specific activity = U/mL ÷ mg/mL</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
