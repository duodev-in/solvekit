<x-calc.page
    title="Rule of 114 and 144 Calculator - SolveKit"
    description="Free Rule of 114 and 144 Calculator: triple ≈ 114 ÷ rate. Like the Rule of 72 for doubling, 114 and 144 estimate the years to triple and quadruple money at a compound rate."
    lede="Work out the years to triple (Rule of 114) from the annual return."
    about="Like the Rule of 72 for doubling, 114 and 144 estimate the years to triple and quadruple money at a compound rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'rule_of_114_and_144', 'fields' => ['rate']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Annual return.'],
        ['name' => 'Read the result', 'text' => 'The years to triple (Rule of 114) appears as you type, with years to quadruple (Rule of 144), exact years to triple, exact years to quadruple below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the years to triple (Rule of 114)?', 'answer' => 'Triple ≈ 114 ÷ rate; quadruple ≈ 144 ÷ rate.'],
        ['question' => 'What is the years to triple (Rule of 114) for annual return 8%?', 'answer' => '14.25 years. Years to quadruple (Rule of 144): 18 years.'],
        ['question' => 'And for annual return 6%?', 'answer' => '19 years. Years to quadruple (Rule of 144): 24 years.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Exact values use logarithms: ln 3 ÷ ln(1 + r).'],
    ]"
>
    <x-calc.field name="rate" label="Annual return" value="8" step="any" suffix="%" />

    <x-calc.result label="Years to triple (Rule of 114)" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rate' => 8],
        'Example B' => ['rate' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Years to quadruple (Rule of 144)'],
            'r2' => ['label' => 'Exact years to triple'],
            'r3' => ['label' => 'Exact years to quadruple'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>triple ≈ 114 ÷ rate</li>
            <li>quadruple ≈ 144 ÷ rate</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
