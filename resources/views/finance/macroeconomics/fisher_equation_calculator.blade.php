<x-calc.page
    title="Fisher Equation Calculator - SolveKit"
    description="Free Fisher Equation Calculator: r = (1 + i) ÷ (1 + π) − 1. The Fisher equation gives the real rate from the nominal rate and inflation."
    lede="Work out the real interest rate from nominal interest rate and inflation."
    about="The Fisher equation gives the real rate from the nominal rate and inflation. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'fisher_equation', 'fields' => ['nominal', 'inflation']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal interest rate, Inflation.'],
        ['name' => 'Read the result', 'text' => 'The real interest rate appears as you type, with approximation below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the real interest rate?', 'answer' => 'R = (1 + i) ÷ (1 + π) − 1.'],
        ['question' => 'What is the real interest rate for nominal interest rate 6%, inflation 3.5%?', 'answer' => '2.415%. Approximation: 2.5%.'],
        ['question' => 'And for nominal interest rate 2%, inflation 4%?', 'answer' => '−1.923%. Approximation: −2%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Approximately i − π.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nominal" label="Nominal interest rate" value="6" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Inflation" value="3.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Real interest rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['nominal' => 6, 'inflation' => 3.5],
        'Example B' => ['nominal' => 2, 'inflation' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Approximation'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = (1 + i) ÷ (1 + π) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
