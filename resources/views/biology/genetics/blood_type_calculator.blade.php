<x-calc.page
    title="Blood Type Calculator - SolveKit"
    description="Free blood type calculator: possible and impossible ABO and Rh blood types of a child from the parents' blood types."
    lede="See which blood types a child can and cannot have."
    about="ABO blood type comes from the A, B and O alleles (A and B are codominant, O is recessive) and Rh from a dominant + allele. A type A or B parent may carry a hidden O, and an Rh+ parent a hidden −, so several types are usually possible. Rare variants such as Bombay and cis-AB are not covered."
    :calc="['engine' => 'genetics', 'tool' => 'blood_type', 'fields' => ['mother_abo', 'mother_rh', 'father_abo', 'father_rh']]"
    :how-to="[
        ['name' => 'Pick each parent\'s type', 'text' => 'ABO and Rh.'],
        ['name' => 'Read the list', 'text' => 'Possible and not-possible types for a child.'],
    ]"
    :faqs="[
        ['question' => 'Can two O parents have an A child?', 'answer' => 'Not under standard ABO inheritance; both can only pass on O.'],
        ['question' => 'Can two Rh+ parents have an Rh− child?', 'answer' => 'Yes, if both carry a hidden Rh− allele.'],
        ['question' => 'Can this prove parentage?', 'answer' => 'No. Blood type can only rule some combinations out, and rare variants exist; use DNA testing.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mother_abo" label="Parent 1 ABO" :options="['A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O']" selected="A" />
        <x-calc.segmented name="mother_rh" legend="Parent 1 Rh" :options="['+' => 'Rh+', '-' => 'Rh−']" selected="+" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="father_abo" label="Parent 2 ABO" :options="['A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O']" selected="B" />
        <x-calc.segmented name="father_rh" legend="Parent 2 Rh" :options="['+' => 'Rh+', '-' => 'Rh−']" selected="+" />
    </div>

    <x-calc.result label="Possible blood types" />

    <x-calc.options :examples="[
        'A+ and B+' => ['mother_abo' => 'A', 'mother_rh' => '+', 'father_abo' => 'B', 'father_rh' => '+'],
        'O− and O−' => ['mother_abo' => 'O', 'mother_rh' => '-', 'father_abo' => 'O', 'father_rh' => '-'],
        'AB+ and O−' => ['mother_abo' => 'AB', 'mother_rh' => '+', 'father_abo' => 'O', 'father_rh' => '-'],
    ]" />

    <x-slot:panel>
        <x-calc.quick-ref heading="All eight types" name="types" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ABO: A and B codominant, O recessive</li>
            <li>Rh: + dominant over −</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
