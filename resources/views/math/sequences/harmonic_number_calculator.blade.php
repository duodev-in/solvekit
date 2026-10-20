<x-calc.page
    title="Harmonic Number Calculator - SolveKit"
    description="Free harmonic number calculator: Hₙ = 1 + 1/2 + … + 1/n as an exact fraction and decimal."
    lede="Find a harmonic number."
    about="The n-th harmonic number is Hₙ = 1 + 1/2 + 1/3 + … + 1/n. It grows like ln n + γ (γ ≈ 0.5772, the Euler–Mascheroni constant), so the harmonic series diverges, but very slowly."
    :calc="['engine' => 'mt-seq', 'tool' => 'harmonic', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is H₁₀?', 'answer' => '2.92896825396825.'],
    ]"
>
    <x-calc.field name="n" label="n" value="10" type="text" inputmode="decimal" />

    <x-calc.result label="Hₙ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '10'],
        'Large' => ['n' => '1000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact fraction'],
            'approx' => ['label' => 'ln n + γ approximation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Hₙ = Σ 1/k</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
