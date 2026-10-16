<x-calc.page
    title="Chemical Oxygen Demand Calculator - SolveKit"
    description="Free COD calculator: chemical oxygen demand from a dichromate titration, or theoretical oxygen demand from a formula."
    lede="Work out chemical oxygen demand from a titration or a formula."
    about="In the dichromate reflux method (Standard Methods 5220), COD = (A − B) × N × 8000 ÷ sample volume, where A and B are the ferrous ammonium sulfate volumes for the blank and the sample. The theoretical oxygen demand of a known compound comes from oxidizing it fully to CO₂ and H₂O."
    :calc="['engine' => 'chem-organic', 'tool' => 'cod', 'fields' => ['mode', 'blank', 'sample_titrant', 'normality', 'sample_volume', 'formula', 'concentration'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Enter the titration volumes', 'text' => 'Blank and sample, in mL.'],
        ['name' => 'Or a compound', 'text' => 'For its theoretical oxygen demand.'],
    ]"
    :faqs="[
        ['question' => 'What is COD?', 'answer' => 'The oxygen needed to chemically oxidize the organic matter in water.'],
        ['question' => 'What is the 8000?', 'answer' => '8 g of oxygen per equivalent × 1000 mL/L.'],
        ['question' => 'What is the ThOD of glucose?', 'answer' => '1.066 g O₂ per g.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['dichromate' => 'Titration', 'theoretical' => 'Formula']" selected="dichromate" />

    <div data-show-when="mode:dichromate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="blank" label="Blank titrant A" value="10" min="0" suffix="mL" />
            <x-calc.field name="sample_titrant" label="Sample titrant B" value="6" min="0" suffix="mL" />
        </div>
    </div>

    <div data-show-when="mode:dichromate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="normality" label="FAS normality" value="0.25" min="0" suffix="N" />
            <x-calc.field name="sample_volume" label="Sample volume" value="20" min="0" suffix="mL" />
        </div>
    </div>

    <div data-show-when="mode:theoretical" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="formula" label="Compound" value="C6H12O6" type="text" help="e.g. H2SO4, Ca(OH)2, CuSO4·5H2O" />
            <x-calc.field name="concentration" label="Concentration (optional)" value="500" min="0" suffix="mg/L" placeholder="Optional" />
        </div>
    </div>

    <x-calc.result label="COD" />

    <x-calc.options :examples="[
        'Wastewater titration' => ['mode' => 'dichromate', 'blank' => 10, 'sample_titrant' => 6, 'normality' => 0.25, 'sample_volume' => 20],
        'Glucose 500 mg/L' => ['mode' => 'theoretical', 'formula' => 'C6H12O6', 'concentration' => 500],
        'Potassium hydrogen phthalate standard' => ['mode' => 'theoretical', 'formula' => 'C8H5KO4', 'concentration' => 425],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cod' => ['label' => 'COD'],
            'weight' => ['label' => 'Detail'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>COD = (A − B) × N × 8000 ÷ V sample</li>
            <li>ThOD: CcHhOoNn + (c + (h − 3n)/4 − o/2) O₂ → products</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
