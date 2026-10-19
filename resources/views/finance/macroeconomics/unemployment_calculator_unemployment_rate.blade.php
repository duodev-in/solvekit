<x-calc.page
    title="Unemployment Calculator (Unemployment Rate) - SolveKit"
    description="Free Unemployment Calculator (Unemployment Rate): u = unemployed ÷ labor force. The unemployment rate is the share of the labor force without a job and looking for one (BLS U-3)."
    lede="Work out the unemployment rate from unemployed and employed."
    about="The unemployment rate is the share of the labor force without a job and looking for one (BLS U-3). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'unemployment_calculator_unemployment_rate', 'fields' => ['unemployed', 'employed']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Unemployed, Employed.'],
        ['name' => 'Read the result', 'text' => 'The unemployment rate appears as you type, with labor force below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the unemployment rate?', 'answer' => 'U = unemployed ÷ labor force.'],
        ['question' => 'What is the unemployment rate for unemployed 7,000,000, employed 161,000,000?', 'answer' => '4.167%. Labor force: 168,000,000.'],
        ['question' => 'And for unemployed 350, employed 4,650?', 'answer' => '7%. Labor force: 5,000.'],
        ['question' => 'What does the result tell me?', 'answer' => 'People not looking are outside the labor force.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="unemployed" label="Unemployed" value="7000000" step="any" />
        <x-calc.field name="employed" label="Employed" value="161000000" step="any" />
    </div>

    <x-calc.result label="Unemployment rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['unemployed' => 7000000, 'employed' => 161000000],
        'Example B' => ['unemployed' => 350, 'employed' => 4650],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Labor force'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>u = unemployed ÷ labor force</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
