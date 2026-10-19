<x-calc.page
    title="Real Rate of Return Calculator - SolveKit"
    description="Free Real Rate of Return Calculator: real = (1 + nominal) ÷ (1 + inflation) − 1 (Fisher). The real return is the gain in purchasing power after inflation."
    lede="Work out the real return from nominal return and inflation."
    about="The real return is the gain in purchasing power after inflation. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'real_rate_of_return', 'fields' => ['nominal', 'inflation']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal return, Inflation.'],
        ['name' => 'Read the result', 'text' => 'The real return appears as you type, with approximation (nominal − inflation) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the real return?', 'answer' => 'Real = (1 + nominal) ÷ (1 + inflation) − 1 (Fisher).'],
        ['question' => 'What is the real return for nominal return 8%, inflation 3%?', 'answer' => '4.854%. Approximation (nominal − inflation): 5%.'],
        ['question' => 'And for nominal return 4%, inflation 6%?', 'answer' => '−1.887%. Approximation (nominal − inflation): −2%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Simply subtracting gives 5%; the exact figure is 4.85%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nominal" label="Nominal return" value="8" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Inflation" value="3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Real return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['nominal' => 8, 'inflation' => 3],
        'Example B' => ['nominal' => 4, 'inflation' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Approximation (nominal − inflation)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>real = (1 + nominal) ÷ (1 + inflation) − 1 (Fisher)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
