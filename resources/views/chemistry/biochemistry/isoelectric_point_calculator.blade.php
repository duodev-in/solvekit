<x-calc.page
    title="Isoelectric Point Calculator - SolveKit"
    description="Free isoelectric point calculator: protein pI and net charge from the amino-acid sequence with EMBOSS or Bjellqvist pKa values."
    lede="Work out a protein's isoelectric point from its sequence."
    about="The net charge is summed from the N-terminus, C-terminus and each ionizable side chain (Asp, Glu, Cys, Tyr, His, Lys, Arg) with the Henderson–Hasselbalch equation, and the pH where it is zero is found by bisection. Published pKa sets differ, so pI values vary by tool: EMBOSS uses one set and ExPASy and Biopython use Bjellqvist's. Both are shown."
    :calc="['engine' => 'chem-biochem', 'tool' => 'isoelectric', 'fields' => ['sequence', 'pka_set'], 'data' => ['pka_sets' => config('chemistry_data.pka_sets')]]"
    :how-to="[
        ['name' => 'Paste the sequence', 'text' => 'One-letter amino-acid codes.'],
        ['name' => 'Pick the pKa set', 'text' => 'To match the tool you compare with.'],
    ]"
    :faqs="[
        ['question' => 'What is the isoelectric point?', 'answer' => 'The pH where the protein carries no net charge.'],
        ['question' => 'Why do tools give different pI values?', 'answer' => 'They use different pKa sets for the ionizable groups.'],
        ['question' => 'Why does pI matter?', 'answer' => 'Proteins are least soluble at their pI, and it guides ion-exchange chromatography.'],
    ]"
>
    <x-calc.textarea name="sequence" label="Protein sequence" value="MQIFVKTLTGKTITLEVEPSDTIENVKAKIQDKEGIPPDQQRLIFAGKQLEDGRTLSDYNIQKESTLHLVLRLRGG" help="One-letter codes; FASTA headers are ignored" rows="4" />

    <x-calc.select name="pka_set" label="pKa set" :options="collect(config('chemistry_data.pka_sets'))->map(fn ($s) => $s['name'])->all()" selected="bjellqvist" />

    <x-calc.result label="Isoelectric point" />

    <x-calc.options :examples="[
        'Ubiquitin' => ['sequence' => 'MQIFVKTLTGKTITLEVEPSDTIENVKAKIQDKEGIPPDQQRLIFAGKQLEDGRTLSDYNIQKESTLHLVLRLRGG', 'pka_set' => 'bjellqvist'],
        'Short peptide INGAR' => ['sequence' => 'INGAR', 'pka_set' => 'bjellqvist'],
        'Ubiquitin, EMBOSS values' => ['sequence' => 'MQIFVKTLTGKTITLEVEPSDTIENVKAKIQDKEGIPPDQQRLIFAGKQLEDGRTLSDYNIQKESTLHLVLRLRGG', 'pka_set' => 'emboss'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'charge7' => ['label' => 'Net charge at pH 7'],
            'length' => ['label' => 'Length'],
            'other' => ['label' => 'With the other pKa set'],
        ]" />
        <x-calc.quick-ref heading="Net charge by pH" name="charges" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>charge = Σ 1/(1 + 10^(pH − pKa)) − Σ 1/(1 + 10^(pKa − pH))</li>
            <li>pI: charge = 0, found by bisection</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
