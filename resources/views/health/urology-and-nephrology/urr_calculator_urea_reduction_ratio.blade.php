<x-calc.page
    title="URR Calculator - Urea Reduction Ratio - SolveKit"
    description="Free URR calculator: urea reduction ratio for a dialysis session from pre- and post-dialysis urea."
    lede="Calculate the urea reduction ratio."
    about="URR = (pre-dialysis urea − post-dialysis urea) ÷ pre-dialysis urea × 100. A URR of 65% or more corresponds roughly to an spKt/V of 1.2. URR ignores urea removed with fluid, so Kt/V is the preferred measure. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-labs', 'tool' => 'urr', 'fields' => ['pre', 'post']]"
    :how-to="[
        ['name' => 'Enter both urea results', 'text' => 'Same unit for both.'],
    ]"
    :faqs="[
        ['question' => 'What is the URR for 60 → 18?', 'answer' => '70%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pre" label="Pre-dialysis urea" value="60" min="0" step="any" />
        <x-calc.field name="post" label="Post-dialysis urea" value="18" min="0" step="any" />
    </div>

    <x-calc.result label="Urea reduction ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pre' => 60, 'post' => 18],
        'Low' => ['pre' => 70, 'post' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'approx' => ['label' => 'Approximate Kt/V'],
            'formula' => ['label' => 'Formula'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>URR = (pre − post) ÷ pre</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
