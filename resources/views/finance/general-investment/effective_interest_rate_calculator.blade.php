<x-calc.page
    title="Effective Interest Rate Calculator - SolveKit"
    description="Free Effective Interest Rate Calculator: i = (1 + r/n)^n − 1. The effective interest rate is the true annual cost or yield once compounding is included."
    lede="Work out the effective interest rate from nominal annual rate and compounding periods a year."
    about="The effective interest rate is the true annual cost or yield once compounding is included. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'effective_interest_rate', 'fields' => ['rate', 'n']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal annual rate, Compounding periods a year.'],
        ['name' => 'Read the result', 'text' => 'The effective interest rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the effective interest rate?', 'answer' => 'I = (1 + r/n)^n − 1.'],
        ['question' => 'What is the effective interest rate for nominal annual rate 8%, compounding periods a year 12?', 'answer' => '8.3%.'],
        ['question' => 'And for nominal annual rate 18%, compounding periods a year 365?', 'answer' => '19.72%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Monthly compounding adds about 0.3 points to an 8% rate.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Nominal annual rate" value="8" step="any" suffix="%" />
        <x-calc.field name="n" label="Compounding periods a year" value="12" min="0" step="1" />
    </div>

    <x-calc.result label="Effective interest rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rate' => 8, 'n' => 12],
        'Example B' => ['rate' => 18, 'n' => 365],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>i = (1 + r/n)^n − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
