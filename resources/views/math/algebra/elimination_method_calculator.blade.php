<x-calc.page
    title="Elimination Method Calculator - SolveKit"
    description="Free elimination method calculator: solve linear equations by eliminating variables (adding multiples of equations), step by step."
    lede="Solve by elimination."
    about="Elimination adds a multiple of one equation to another to cancel a variable, repeating until each equation has one unknown. The row operations shown are exactly these steps."
    :calc="['engine' => 'mt-algebra', 'tool' => 'system', 'fields' => ['eqs']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve 2x + 3y = 7 and x − y = 1.', 'answer' => 'x = 2,  y = 1.'],
    ]"
>
    <x-calc.textarea name="eqs" label="Equations (one per line)" value="2x + 3y = 7
x - y = 1" rows="3" />

    <x-calc.result label="Solution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eqs' => '2x + 3y = 7
x - y = 1'],
        'Fractions' => ['eqs' => 'x/2 + y = 3
3x - 2y = 2'],
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
            <li>add multiples of equations</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
