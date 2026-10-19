<x-calc.page
    title="Okun's Law Calculator - SolveKit"
    description="Free Okun's Law Calculator: gap ≈ −β (u − u*). Okun's law links unemployment above its natural rate to output below potential; β of about 2 is common for the US."
    lede="Work out the output gap from unemployment rate, natural rate and Okun coefficient."
    about="Okun's law links unemployment above its natural rate to output below potential; β of about 2 is common for the US. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'okuns_law', 'fields' => ['u', 'natural', 'beta']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Unemployment rate, Natural rate, Okun coefficient.'],
        ['name' => 'Read the result', 'text' => 'The output gap appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the output gap?', 'answer' => 'Gap ≈ −β (u − u*).'],
        ['question' => 'What is the output gap for unemployment rate 6%, natural rate 4.5%, Okun coefficient 2?', 'answer' => '−3%.'],
        ['question' => 'And for unemployment rate 3.8%, natural rate 4.4%, Okun coefficient 2?', 'answer' => '1.2%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'An empirical rule, not exact.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="u" label="Unemployment rate" value="6" step="any" suffix="%" />
        <x-calc.field name="natural" label="Natural rate" value="4.5" step="any" suffix="%" />
        <x-calc.field name="beta" label="Okun coefficient" value="2" step="any" />
    </div>

    <x-calc.result label="Output gap" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['u' => 6, 'natural' => 4.5, 'beta' => 2],
        'Example B' => ['u' => 3.8, 'natural' => 4.4, 'beta' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gap ≈ −β (u − u*)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
