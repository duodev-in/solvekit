<x-calc.page
    title="Ligation Calculator - SolveKit"
    description="Free ligation calculator: ng of insert for a chosen insert to vector molar ratio from vector amount and fragment sizes."
    lede="Work out how much insert to add for a ligation at a chosen molar ratio."
    about="Ligations are set up by molar ratio, not mass. Because a fragment's mass is proportional to its length, the insert mass is the vector mass × ratio × insert length ÷ vector length. 3:1 is a common starting point."
    :calc="['engine' => 'lab', 'tool' => 'ligation', 'fields' => ['vector_ng', 'vector_bp', 'insert_bp', 'ratio']]"
    :how-to="[
        ['name' => 'Enter the vector', 'text' => 'Mass and length of the linearized vector.'],
        ['name' => 'Enter the insert length', 'text' => 'In base pairs.'],
        ['name' => 'Pick a ratio', 'text' => '3:1 is typical; try 1:1 to 7:1.'],
    ]"
    :faqs="[
        ['question' => 'What insert to vector ratio is best?', 'answer' => '3:1 is a good start; short inserts often need 5:1 or more.'],
        ['question' => 'How much vector should I use?', 'answer' => 'Usually 50 to 100 ng in a 20 µL ligation.'],
        ['question' => 'Where does 650 come from?', 'answer' => 'The average mass of one base pair of dsDNA in g/mol, used for the pmol values.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="vector_ng" label="Vector amount" value="50" min="0" suffix="ng" />
        <x-calc.field name="vector_bp" label="Vector length" value="3000" min="0" suffix="bp" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="insert_bp" label="Insert length" value="1000" min="0" suffix="bp" />
        <x-calc.field name="ratio" label="Insert : vector ratio" value="3" min="0" />
    </div>

    <x-calc.result label="Insert needed" />

    <x-calc.options :examples="[
        '1 kb into 3 kb, 3:1' => ['vector_ng' => 50, 'vector_bp' => 3000, 'insert_bp' => 1000, 'ratio' => 3],
        '300 bp into 5.4 kb, 5:1' => ['vector_ng' => 100, 'vector_bp' => 5400, 'insert_bp' => 300, 'ratio' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Amounts" :rows="[
            'vector_pmol' => ['label' => 'Vector'],
            'insert_pmol' => ['label' => 'Insert'],
        ]" />
        <x-calc.quick-ref heading="Other ratios" name="quick-ref" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>insert ng = ratio × vector ng × insert bp ÷ vector bp</li>
            <li>pmol = ng × 1000 ÷ (bp × 650)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
