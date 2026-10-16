<x-calc.page
    title="Trihybrid Cross Calculator - SolveKit"
    description="Free trihybrid cross calculator: build the 8 × 8 Punnett square for two parents and get genotype and phenotype ratios."
    lede="Cross two parents across 3 genes and get the Punnett square and ratios."
    about="Each parent passes one allele of each gene to every gamete. With independent assortment a parent heterozygous at 3 genes makes 8 kinds of gamete, so the square has 64 cells. A capital letter is the dominant allele; the heterozygous AaBbCc cross gives the classic 27:9:9:9:3:3:3:1 phenotype ratio."
    :calc="['engine' => 'genetics', 'tool' => 'trihybrid', 'fields' => ['parent_a', 'parent_b']]"
    :how-to="[
        ['name' => 'Enter both genotypes', 'text' => 'Letter pairs per gene, e.g. AaBbCc. Upper case is dominant.'],
        ['name' => 'Read the square', 'text' => 'Rows are parent 1\'s gametes, columns parent 2\'s.'],
        ['name' => 'Read the ratios', 'text' => 'Genotype and phenotype counts out of every cell.'],
    ]"
    :faqs="[
        ['question' => 'How many cells does a trihybrid square have?', 'answer' => '64: eight gamete types from each parent.'],
        ['question' => 'What is the trihybrid ratio?', 'answer' => '27:9:9:9:3:3:3:1 for two triple heterozygotes.'],
        ['question' => 'How many genotypes are possible?', 'answer' => '27, three per gene.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="parent_a" label="Parent 1 genotype" value="AaBbCc" type="text" placeholder="AaBbCc" />
        <x-calc.field name="parent_b" label="Parent 2 genotype" value="AaBbCc" type="text" placeholder="AaBbCc" />
    </div>

    <x-calc.result label="Phenotype ratio" />

    <x-calc.options :examples="[
        'AaBbCc × AaBbCc' => ['parent_a' => 'AaBbCc', 'parent_b' => 'AaBbCc'],
        'AaBbCc × aabbcc' => ['parent_a' => 'AaBbCc', 'parent_b' => 'aabbcc'],
    ]" />

    <x-slot:panel>
        <x-calc.grid heading="Punnett square" name="grid" />
        <x-calc.quick-ref heading="Phenotypes" name="phenotypes" :generated="true" />
        <x-calc.quick-ref heading="Genotypes" name="genotypes" :generated="true" :collapse="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gametes: one allele per gene, all combinations</li>
            <li>cells = 8 × 8 = 64</li>
            <li>phenotype: dominant if at least one capital allele</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
