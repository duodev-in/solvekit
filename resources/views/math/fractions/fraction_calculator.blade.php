<x-calc.page
    title="Fraction Calculator - SolveKit"
    description="Free fraction calculator: add, subtract, multiply and divide fractions and mixed numbers, with brackets and powers, giving the exact answer in lowest terms with steps."
    lede="Calculate with fractions exactly."
    about="Type any fraction expression: 3/4 + 5/6, (1 1/2) × 2/3, (2/3)^2 ÷ 4. Mixed numbers go in brackets. The result is exact (no rounding), reduced to lowest terms and also shown as a mixed number and a decimal."
    :calc="['engine' => 'mt-frac', 'tool' => 'expression', 'fields' => ['expr']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 3/4 + 5/6?', 'answer' => '19/12 (Mixed number 1 7/12).'],
        ['question' => 'What is (2/3)² ÷ 4?', 'answer' => '1/9.'],
    ]"
>
    <x-calc.field name="expr" label="Fraction expression" value="3/4 + 5/6" type="text" help="Use + − * / ^ and brackets; write mixed numbers as (1 1/2)" inputmode="text" />

    <x-calc.result label="Result in lowest terms" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expr' => '3/4 + 5/6'],
        'Power' => ['expr' => '(2/3)^2 / 4'],
        'Mixed' => ['expr' => '(2 1/2) * (1 1/3)'],
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
