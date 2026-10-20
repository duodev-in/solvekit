<x-calc.page
    title="Arithmetic Sequence Calculator - SolveKit"
    description="Free arithmetic sequence calculator: the n-th term and the sum of the first n terms from a₁ and the common difference d."
    lede="Work with an arithmetic sequence."
    about="An arithmetic sequence adds the same difference d each time: 3, 7, 11, 15, … has d = 4. The n-th term is aₙ = a₁ + (n − 1)d and the sum of n terms Sₙ = n(a₁ + aₙ)/2, Gauss's trick of pairing first and last."
    :calc="['engine' => 'mt-seq', 'tool' => 'arithmetic', 'fields' => ['a1', 'd', 'n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the 20th term of 3, 7, 11, …?', 'answer' => '79.'],
        ['question' => 'And the sum of the first 20 terms?', 'answer' => '820.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a1" label="First term a₁" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="d" label="Common difference d" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="n" label="Term number n" value="20" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="n-th term" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a1' => '3', 'd' => '4', 'n' => '20'],
        'Fractions' => ['a1' => '1/2', 'd' => '-1/3', 'n' => '10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Sum of n terms'],
            'terms' => ['label' => 'First terms'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>aₙ = a₁ + (n − 1)d</li>
            <li>Sₙ = n(a₁ + aₙ)/2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
