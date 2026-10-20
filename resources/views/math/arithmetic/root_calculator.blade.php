<x-calc.page
    title="Root Calculator - SolveKit"
    description="Free root calculator: the n-th root of any number, exactly when it is rational and as a simplified radical otherwise."
    lede="Find any root."
    about="The n-th root of x is the number that gives x when raised to the n-th power. Odd roots of negative numbers are real (∛−8 = −2); even roots of negative numbers are imaginary. Non-perfect powers are simplified: ⁴√48 = 2⁴√3."
    :calc="['engine' => 'mt-number', 'tool' => 'roots', 'fields' => ['x', 'index']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the fourth root of 48?', 'answer' => '2.6321480259 (Exact form 2⁴√3).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="Number" value="48" type="text" inputmode="text" />
        <x-calc.field name="index" label="Root (n)" value="4" min="2" max="100" step="1" />
    </div>

    <x-calc.result label="Root" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => '48', 'index' => 4],
        'Exact' => ['x' => '1024', 'index' => 5],
        'Negative' => ['x' => '-125', 'index' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact form'],
            'decimal' => ['label' => 'Decimal'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ⁿ√x = x^(1/n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
