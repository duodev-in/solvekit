<x-calc.page
    title="Convolution Calculator - SolveKit"
    description="Free convolution calculator: the discrete convolution of two sequences, exactly, with each term."
    lede="Convolve two sequences."
    about="The discrete convolution (a ∗ b)ₙ = Σ aₖbₙ₋ₖ slides one sequence across the other and adds products. It multiplies polynomials (coefficient lists), smooths signals with filters and adds independent random variables."
    :calc="['engine' => 'mt-seq', 'tool' => 'convolution', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is (1, 2, 3) ∗ (0, 1, 0.5)?', 'answer' => '0, 1, 2.5, 4, 1.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Sequence a" value="1, 2, 3" type="text" inputmode="text" />
        <x-calc.field name="b" label="Sequence b" value="0, 1, 0.5" type="text" inputmode="text" />
    </div>

    <x-calc.result label="a ∗ b" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '1, 2, 3', 'b' => '0, 1, 0.5'],
        'Dice' => ['a' => '1, 1, 1, 1, 1, 1', 'b' => '1, 1, 1, 1, 1, 1'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'length' => ['label' => 'Length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(a ∗ b)ₙ = Σ aₖbₙ₋ₖ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
