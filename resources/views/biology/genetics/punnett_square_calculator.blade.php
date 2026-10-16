<x-calc.page
    title="Punnett Square Calculator - SolveKit"
    description="Free Punnett square calculator: build the 2 × 2 Punnett square for two parents and get genotype and phenotype ratios."
    lede="Cross two parents across 1 gene and get the Punnett square and ratios."
    about="Each parent passes one allele of each gene to every gamete. With independent assortment a parent heterozygous at 1 gene makes 2 kinds of gamete, so the square has 4 cells. A capital letter is the dominant allele; the heterozygous Aa cross gives the classic 3:1 phenotype ratio."
    :calc="['engine' => 'genetics', 'tool' => 'monohybrid', 'fields' => ['parent_a', 'parent_b']]"
    :how-to="[
        ['name' => 'Enter both genotypes', 'text' => 'Letter pairs per gene, e.g. Aa. Upper case is dominant.'],
        ['name' => 'Read the square', 'text' => 'Rows are parent 1\'s gametes, columns parent 2\'s.'],
        ['name' => 'Read the ratios', 'text' => 'Genotype and phenotype counts out of every cell.'],
    ]"
    :faqs="[
        ['question' => 'What does a Punnett square show?', 'answer' => 'Every combination of the parents\' alleles and how likely each offspring genotype is.'],
        ['question' => 'Why is Aa × Aa a 3:1 ratio?', 'answer' => 'Three of the four cells have at least one dominant A.'],
        ['question' => 'What is a test cross?', 'answer' => 'Crossing with a homozygous recessive (aa) to reveal an unknown genotype.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="parent_a" label="Parent 1 genotype" value="Aa" type="text" placeholder="Aa" />
        <x-calc.field name="parent_b" label="Parent 2 genotype" value="Aa" type="text" placeholder="Aa" />
    </div>

    <x-calc.result label="Phenotype ratio" />

    <x-calc.options :examples="[
        'Aa × Aa' => ['parent_a' => 'Aa', 'parent_b' => 'Aa'],
        'Test cross Aa × aa' => ['parent_a' => 'Aa', 'parent_b' => 'aa'],
        'AA × aa' => ['parent_a' => 'AA', 'parent_b' => 'aa'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="Punnett square" name="grid" />
        <x-calc.quick-ref heading="Phenotypes" name="phenotypes" :generated="true" />
        <x-calc.quick-ref heading="Genotypes" name="genotypes" :generated="true" :collapse="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gametes: one allele per gene, all combinations</li>
            <li>cells = 2 × 2 = 4</li>
            <li>phenotype: dominant if at least one capital allele</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
