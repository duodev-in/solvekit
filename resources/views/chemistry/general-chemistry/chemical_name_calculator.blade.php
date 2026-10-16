<x-calc.page
    title="Chemical Name Calculator - SolveKit"
    description="Free chemical name calculator: name inorganic compounds from their formula, or write the formula from the name, using IUPAC rules."
    lede="Name an inorganic compound from its formula, or get the formula from its name."
    about="Covers ionic compounds (with Roman numerals for metals that have more than one charge), binary molecular compounds with Greek prefixes, acids and hydrates, following IUPAC conventions. Organic compounds are not covered, because one molecular formula can match many structures."
    :calc="['engine' => 'chem-general', 'tool' => 'chemical_name', 'fields' => ['mode', 'query'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name'])]]"
    :how-to="[
        ['name' => 'Pick the direction', 'text' => 'Formula to name, or name to formula.'],
        ['name' => 'Type it in', 'text' => 'Use brackets for repeated polyatomic ions, e.g. Ca(NO3)2.'],
    ]"
    :faqs="[
        ['question' => 'When is a Roman numeral used?', 'answer' => 'For metals with more than one possible charge, e.g. iron(II) and iron(III).'],
        ['question' => 'Why is it dinitrogen pentaoxide?', 'answer' => 'IUPAC keeps the vowel; “pentoxide” is the common spelling and is accepted as input.'],
        ['question' => 'Can it name organic compounds?', 'answer' => 'No: a formula such as C2H6O can be ethanol or dimethyl ether.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Convert" :options="['formula' => 'Formula → name', 'name' => 'Name → formula']" selected="formula" />

    <x-calc.field name="query" label="Formula or name" value="Fe2(SO4)3" type="text" help="e.g. CuSO4·5H2O, N2O5, iron(III) chloride, sulfuric acid" />

    <x-calc.result label="Name" />

    <x-calc.options :decimals="false" :examples="[
        'Fe₂(SO₄)₃' => ['mode' => 'formula', 'query' => 'Fe2(SO4)3'],
        'CuSO₄·5H₂O' => ['mode' => 'formula', 'query' => 'CuSO4·5H2O'],
        'N₂O₅' => ['mode' => 'formula', 'query' => 'N2O5'],
        'Ammonium phosphate' => ['mode' => 'name', 'query' => 'ammonium phosphate'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'type' => ['label' => 'Compound type'],
            'detail' => ['label' => 'Ions or other name'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ionic: cation name + anion name; Roman numeral = cation charge</li>
            <li>molecular: prefix + element, prefix + -ide</li>
            <li>oxyacids: -ate → -ic acid, -ite → -ous acid</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
