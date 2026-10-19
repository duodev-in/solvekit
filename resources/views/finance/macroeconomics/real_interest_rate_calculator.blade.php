<x-calc.page
    title="Real Interest Rate Calculator - SolveKit"
    description="Free Real Interest Rate Calculator: r = (1 + i) ÷ (1 + π) − 1. The real rate is the return or cost after inflation."
    lede="Work out the real interest rate from nominal interest rate and inflation."
    about="The real rate is the return or cost after inflation. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'real_interest_rate', 'fields' => ['nominal', 'inflation']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal interest rate, Inflation.'],
        ['name' => 'Read the result', 'text' => 'The real interest rate appears as you type, with approximation below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the real interest rate?', 'answer' => 'R = (1 + i) ÷ (1 + π) − 1.'],
        ['question' => 'What is the real interest rate for nominal interest rate 5%, inflation 3%?', 'answer' => '1.942%. Approximation: 2%.'],
        ['question' => 'And for nominal interest rate 4%, inflation 6.5%?', 'answer' => '−2.347%. Approximation: −2.5%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Negative real rates erode savings.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nominal" label="Nominal interest rate" value="5" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Inflation" value="3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Real interest rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['nominal' => 5, 'inflation' => 3],
        'Example B' => ['nominal' => 4, 'inflation' => 6.5],
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
