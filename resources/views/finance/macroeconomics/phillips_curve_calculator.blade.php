<x-calc.page
    title="Phillips Curve Calculator - SolveKit"
    description="Free Phillips Curve Calculator: π = πᵉ − β(u − u*). The expectations-augmented Phillips curve: inflation falls when unemployment is above its natural rate."
    lede="Work out the inflation from your figures."
    about="The expectations-augmented Phillips curve: inflation falls when unemployment is above its natural rate. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'phillips_curve', 'fields' => ['expected', 'u', 'natural', 'beta']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Expected inflation, Unemployment rate, Natural rate, Slope.'],
        ['name' => 'Read the result', 'text' => 'The inflation appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the inflation?', 'answer' => 'π = πᵉ − β(u − u*).'],
        ['question' => 'What is the inflation for expected inflation 2.5%, unemployment rate 5%, natural rate 4.5%, slope 0.5?', 'answer' => '2.25%.'],
        ['question' => 'And for expected inflation 3%, unemployment rate 3.6%, natural rate 4.4%, slope 0.3?', 'answer' => '3.24%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The slope has been small in recent decades.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expected" label="Expected inflation" value="2.5" step="any" suffix="%" />
        <x-calc.field name="u" label="Unemployment rate" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="natural" label="Natural rate" value="4.5" step="any" suffix="%" />
        <x-calc.field name="beta" label="Slope" value="0.5" step="any" />
    </div>

    <x-calc.result label="Inflation" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['expected' => 2.5, 'u' => 5, 'natural' => 4.5, 'beta' => 0.5],
        'Example B' => ['expected' => 3, 'u' => 3.6, 'natural' => 4.4, 'beta' => 0.3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>π = πᵉ − β(u − u*)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
