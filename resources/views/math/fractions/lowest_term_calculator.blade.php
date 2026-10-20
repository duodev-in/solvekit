<x-calc.page
    title="Lowest Term Calculator - SolveKit"
    description="Free lowest term calculator: write any fraction in lowest terms, using the greatest common factor."
    lede="Put a fraction in lowest terms."
    about="Lowest terms (simplest form) means the top and bottom share no factor greater than 1. 360/480 has GCF 120, so it is 3/4 in lowest terms. Negative signs are moved to the numerator."
    :calc="['engine' => 'mt-frac', 'tool' => 'simplify', 'fields' => ['num', 'den']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 360/480 in lowest terms?', 'answer' => '3/4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="num" label="Numerator" value="360" type="text" inputmode="decimal" />
        <x-calc.field name="den" label="Denominator" value="480" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="In lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['num' => '360', 'den' => '480'],
        'Negative' => ['num' => '-14', 'den' => '21'],
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
            <li>divide by GCF</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
