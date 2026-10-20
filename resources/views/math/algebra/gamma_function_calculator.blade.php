<x-calc.page
    title="Gamma Function Calculator - SolveKit"
    description="Free gamma function calculator: Γ(x) for real and complex x, ln Γ, and the link to factorials."
    lede="Evaluate the gamma function."
    about="The gamma function extends the factorial: Γ(n) = (n − 1)! for positive integers, and Γ(1/2) = √π. It is defined for all complex numbers except 0, −1, −2, …, where it has poles. Values use the Lanczos approximation (about 15 digits)."
    :calc="['engine' => 'mt-alg2', 'tool' => 'special', 'fields' => ['x', 'y'], 'fn' => 'gamma']"
    :how-to="[
        ['name' => 'Type the polynomial or equation', 'text' => 'Use ^ for powers (x^2), * is optional (3x), and fractions are fine.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is Γ(1/2)?', 'answer' => '1.7724538509055 (= √π).'],
        ['question' => 'And Γ(1 + i)?', 'answer' => '0.498015668118 − 0.154949828302i.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="x (real part)" value="0.5" step="any" />
        <x-calc.field name="y" label="Imaginary part (optional)" value="0" step="any" />
    </div>

    <x-calc.result label="Γ(x)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x' => 0.5, 'y' => 0],
        'Integer' => ['x' => 6, 'y' => 0],
        'Complex' => ['x' => 1, 'y' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph of Γ(x)" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'ln' => ['label' => 'ln Γ'],
            'factorial' => ['label' => 'Factorial'],
            'reflection' => ['label' => 'Reflection formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Γ(x) = ∫₀^∞ tˣ⁻¹e⁻ᵗ dt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
