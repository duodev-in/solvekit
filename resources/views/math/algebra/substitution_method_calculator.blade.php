<x-calc.page
    title="Substitution Method Calculator - SolveKit"
    description="Free substitution method calculator: solve two linear equations by substitution, with the exact answer."
    lede="Solve by substitution."
    about="Solve one equation for a variable (x = 1 + y), substitute into the other (2(1 + y) + 3y = 7), solve (y = 1), then back-substitute (x = 2). The answer is the same as by elimination."
    :calc="['engine' => 'mt-algebra', 'tool' => 'system', 'fields' => ['eqs'], 'method' => 'substitution']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve 2x + 3y = 7 and x = y + 1.', 'answer' => 'x = 2,  y = 1.'],
    ]"
>
    <x-calc.textarea name="eqs" label="Equations (one per line)" value="2x + 3y = 7
x - y = 1" rows="3" />

    <x-calc.result label="Solution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eqs' => '2x + 3y = 7
x - y = 1'],
        'Three' => ['eqs' => 'a + b = 5
b + c = 7
a + c = 6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kind' => ['label' => 'Type'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>solve, substitute, back-substitute</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
