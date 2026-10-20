<x-calc.page
    title="System of Equations Calculator - SolveKit"
    description="Free system of equations calculator: solve 2 to 6 linear equations exactly by Gaussian elimination, with unique, no or infinitely many solutions."
    lede="Solve a system of linear equations."
    about="Write one equation per line. The system is solved exactly with fractions by row reduction (Gaussian elimination). A system can have one solution, none (inconsistent) or infinitely many (dependent), given in parametric form."
    :calc="['engine' => 'mt-algebra', 'tool' => 'system', 'fields' => ['eqs']]"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Solve x + y + z = 6, 2x − y + z = 3, x + 2y − z = 2.', 'answer' => 'x = 1,  y = 2,  z = 3.'],
    ]"
>
    <x-calc.textarea name="eqs" label="Equations (one per line)" value="x + y + z = 6
2x - y + z = 3
x + 2y - z = 2" rows="4" />

    <x-calc.result label="Solution" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eqs' => 'x + y + z = 6
2x - y + z = 3
x + 2y - z = 2'],
        'Dependent' => ['eqs' => 'x + y = 2
2x + 2y = 4'],
        'None' => ['eqs' => 'x + y = 1
x + y = 3'],
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
            <li>row reduction</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
