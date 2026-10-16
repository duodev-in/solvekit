<x-calc.page
    title="Molecular Weight Calculator - SolveKit"
    description="Free molecular weight calculator: average molecular weight in daltons plus monoisotopic and nominal mass for mass spectrometry."
    lede="Find the molecular weight of a compound, with its monoisotopic mass."
    about="The average molecular weight uses IUPAC atomic weights, as for weighing. Mass spectrometry sees individual molecules, so it also gives the monoisotopic mass (each element's most abundant isotope, NIST masses) and the nominal (integer) mass."
    :calc="['engine' => 'chem-general', 'tool' => 'molecular_weight', 'fields' => ['formula'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight', 'isotopes'])]]"
    :how-to="[
        ['name' => 'Type the formula', 'text' => 'In any order; the Hill formula is shown.'],
    ]"
    :faqs="[
        ['question' => 'Is molecular weight the same as molar mass?', 'answer' => 'Numerically yes: 1 Da per molecule equals 1 g/mol.'],
        ['question' => 'What is monoisotopic mass?', 'answer' => 'The mass with only the most abundant isotope of each element, the main peak in mass spectrometry.'],
        ['question' => 'Why do they differ?', 'answer' => 'Heavier isotopes such as ¹³C raise the average mass.'],
    ]"
>
    <x-calc.field name="formula" label="Chemical formula" value="C8H10N4O2" type="text" help="e.g. C8H10N4O2 (caffeine)" />

    <x-calc.result label="Molecular weight" />

    <x-calc.options :examples="[
        'Caffeine' => ['formula' => 'C8H10N4O2'],
        'Glucose' => ['formula' => 'C6H12O6'],
        'Aspirin' => ['formula' => 'C9H8O4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mono' => ['label' => 'Monoisotopic mass'],
            'nominal' => ['label' => 'Nominal mass'],
            'hill' => ['label' => 'Hill formula'],
        ]" />
        <x-calc.quick-ref heading="By element" name="parts" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>average: Σ count × atomic weight</li>
            <li>monoisotopic: Σ count × mass of most abundant isotope</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
