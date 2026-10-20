<x-calc.page
    title="Mixed Number Calculator - SolveKit"
    description="Free mixed number calculator: add, subtract, multiply and divide mixed numbers exactly, with the answer as a mixed number and the steps."
    lede="Calculate with mixed numbers."
    about="Mixed numbers such as 2 1/3 are converted to improper fractions (7/3), combined exactly and turned back into a mixed number. Put each mixed number in brackets: (2 1/3) + (1 3/4) = 49/12 = 4 1/12."
    :calc="['engine' => 'mt-frac', 'tool' => 'expression', 'fields' => ['expr']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 2 1/3 + 1 3/4?', 'answer' => 'Mixed number 4 1/12.'],
    ]"
>
    <x-calc.field name="expr" label="Fraction expression" value="(2 1/3) + (1 3/4)" type="text" help="Use + − * / ^ and brackets; write mixed numbers as (1 1/2)" inputmode="text" />

    <x-calc.result label="Result in lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expr' => '(2 1/3) + (1 3/4)'],
        'Times' => ['expr' => '(3 1/2) * (2 2/5)'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mixed' => ['label' => 'Mixed number'],
            'decimal' => ['label' => 'Decimal'],
            'reciprocal' => ['label' => 'Reciprocal'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Exact rational arithmetic</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
