<x-calc.page
    title="Geometric Sequence Calculator - SolveKit"
    description="Free geometric sequence calculator: the n-th term, the sum of n terms and the infinite sum from a₁ and the ratio r."
    lede="Work with a geometric sequence."
    about="A geometric sequence multiplies by the same ratio r each time: 2, 6, 18, 54, … has r = 3. aₙ = a₁rⁿ⁻¹ and Sₙ = a₁(1 − rⁿ)/(1 − r). When |r| < 1 the infinite sum converges to a₁/(1 − r)."
    :calc="['engine' => 'mt-seq', 'tool' => 'geometric', 'fields' => ['a1', 'r', 'n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the 10th term of 2, 6, 18, …?', 'answer' => '39,366.'],
        ['question' => 'What is 1 + 1/2 + 1/4 + … forever?', 'answer' => '2 (|r| < 1).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a1" label="First term a₁" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="r" label="Common ratio r" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="n" label="Term number n" value="10" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="n-th term" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a1' => '2', 'r' => '3', 'n' => '10'],
        'Halves' => ['a1' => '1', 'r' => '1/2', 'n' => '10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Sum of n terms'],
            'infinite' => ['label' => 'Infinite sum'],
            'terms' => ['label' => 'First terms'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>aₙ = a₁rⁿ⁻¹</li>
            <li>S∞ = a₁/(1 − r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
