<x-calc.page
    title="Weighted Average Calculator - SolveKit"
    description="Free weighted average calculator: the average of values with different weights (grades, prices, scores)."
    lede="Calculate a weighted average."
    about="Weighted average = Σ(value × weight) ÷ Σweights. A course with exams 85 (weight 30%), 92 (50%) and 78 (20%) averages 87.1. Weights do not need to add up to 100."
    :calc="['engine' => 'mt-number', 'tool' => 'weighted', 'fields' => ['items']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the weighted average of 85 (30), 92 (50) and 78 (20)?', 'answer' => '87.1.'],
    ]"
>
    <x-calc.textarea name="items" label="Value and weight (one pair per line)" value="85, 30
92, 50
78, 20" rows="5" />

    <x-calc.result label="Weighted average" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['items' => '85, 30
92, 50
78, 20'],
        'Prices' => ['items' => '4.50, 10
5.25, 4'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total weight'],
            'simple' => ['label' => 'Simple average'],
            'sum' => ['label' => 'Σ value × weight'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σwx ÷ Σw</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
