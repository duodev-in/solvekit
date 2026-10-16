<x-calc.page
    title="Dihybrid Cross Calculator - SolveKit"
    description="Free dihybrid cross calculator: build the 4 × 4 Punnett square for two parents and get genotype and phenotype ratios."
    lede="Cross two parents across 2 genes and get the Punnett square and ratios."
    about="Each parent passes one allele of each gene to every gamete. With independent assortment a parent heterozygous at 2 genes makes 4 kinds of gamete, so the square has 16 cells. A capital letter is the dominant allele; the heterozygous AaBb cross gives the classic 9:3:3:1 phenotype ratio."
    :calc="['engine' => 'genetics', 'tool' => 'dihybrid', 'fields' => ['parent_a', 'parent_b']]"
    :how-to="[
        ['name' => 'Enter both genotypes', 'text' => 'Letter pairs per gene, e.g. AaBb. Upper case is dominant.'],
        ['name' => 'Read the square', 'text' => 'Rows are parent 1\'s gametes, columns parent 2\'s.'],
        ['name' => 'Read the ratios', 'text' => 'Genotype and phenotype counts out of every cell.'],
    ]"
    :faqs="[
        ['question' => 'What is a dihybrid cross?', 'answer' => 'A cross that follows two genes at once, such as seed color and shape.'],
        ['question' => 'Why 9:3:3:1?', 'answer' => 'Two independent 3:1 ratios multiply: (3:1) × (3:1).'],
        ['question' => 'Does this work for linked genes?', 'answer' => 'No, it assumes the genes assort independently.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="parent_a" label="Parent 1 genotype" value="AaBb" type="text" placeholder="AaBb" />
        <x-calc.field name="parent_b" label="Parent 2 genotype" value="AaBb" type="text" placeholder="AaBb" />
    </div>

    <x-calc.result label="Phenotype ratio" />

    <x-calc.options :examples="[
        'AaBb × AaBb' => ['parent_a' => 'AaBb', 'parent_b' => 'AaBb'],
        'AaBb × aabb' => ['parent_a' => 'AaBb', 'parent_b' => 'aabb'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="Punnett square" name="grid" />
        <x-calc.quick-ref heading="Phenotypes" name="phenotypes" :generated="true" />
        <x-calc.quick-ref heading="Genotypes" name="genotypes" :generated="true" :collapse="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gametes: one allele per gene, all combinations</li>
            <li>cells = 4 × 4 = 16</li>
            <li>phenotype: dominant if at least one capital allele</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
