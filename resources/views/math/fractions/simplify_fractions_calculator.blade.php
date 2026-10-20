<x-calc.page
    title="Simplify Fractions Calculator - SolveKit"
    description="Free simplify fractions calculator: reduce a fraction to lowest terms by its greatest common factor, with the steps."
    lede="Simplify a fraction."
    about="A fraction is in lowest terms when the numerator and denominator have no common factor except 1. Divide both by their greatest common factor: 84/126 ÷ 42 = 2/3. The GCF comes from Euclid's algorithm or the prime factors."
    :calc="['engine' => 'mt-frac', 'tool' => 'simplify', 'fields' => ['num', 'den']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 84/126 in lowest terms?', 'answer' => '2/3 (Divide top and bottom by 42).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="num" label="Numerator" value="84" type="text" inputmode="decimal" />
        <x-calc.field name="den" label="Denominator" value="126" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="In lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['num' => '84', 'den' => '126'],
        'Improper' => ['num' => '45', 'den' => '12'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'gcf' => ['label' => 'Greatest common factor'],
            'mixed' => ['label' => 'Mixed number'],
            'decimal' => ['label' => 'Decimal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a/b = (a ÷ g)/(b ÷ g)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
