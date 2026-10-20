<x-calc.page
    title="Fundamental Counting Principle Calculator - SolveKit"
    description="Free counting principle calculator: the number of outcomes when choices are made in stages (m × n × …)."
    lede="Count the possible outcomes."
    about="If one choice has m options and the next has n, together there are m × n outcomes. 3 shirts, 4 trousers and 2 pairs of shoes make 24 outfits; a 4-digit PIN has 10⁴ = 10,000 possibilities."
    :calc="['engine' => 'mt-arith', 'tool' => 'counting', 'fields' => ['choices']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'How many outfits from 3 shirts, 4 trousers and 2 shoes?', 'answer' => '24.'],
    ]"
>
    <x-calc.field name="choices" label="Choices at each stage" value="3, 4, 2" type="text" inputmode="text" />

    <x-calc.result label="Outcomes" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['choices' => '3, 4, 2'],
        'PIN' => ['choices' => '10, 10, 10, 10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'stages' => ['label' => 'Stages'],
            'rule' => ['label' => 'Rule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = n₁ × n₂ × …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
