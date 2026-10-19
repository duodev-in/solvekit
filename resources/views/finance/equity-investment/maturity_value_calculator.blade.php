<x-calc.page
    title="Maturity Value Calculator - SolveKit"
    description="Free Maturity Value Calculator: MV = P(1 + r/n)^(nt). The maturity value is what an investment or note is worth when it comes due."
    lede="Work out the maturity value from your figures."
    about="The maturity value is what an investment or note is worth when it comes due. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'maturity_value', 'fields' => ['principal', 'rate', 'years', 'n']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Principal, Annual rate, Years, Compounding periods a year.'],
        ['name' => 'Read the result', 'text' => 'The maturity value appears as you type, with interest earned below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the maturity value?', 'answer' => 'MV = P(1 + r/n)^(nt).'],
        ['question' => 'What is the maturity value for principal $10,000, annual rate 5%, years 3, compounding periods a year 4?', 'answer' => '$11,607.55. Interest earned: $1,607.55.'],
        ['question' => 'And for principal $5,000, annual rate 6.5%, years 5, compounding periods a year 12?', 'answer' => '$6,914.09. Interest earned: $1,914.09.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Use n = 1 for annual, 12 for monthly compounding.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="principal" label="Principal" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="3" min="0" step="any" suffix="years" />
        <x-calc.field name="n" label="Compounding periods a year" value="4" min="0" step="1" />
    </div>

    <x-calc.result label="Maturity value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['principal' => 10000, 'rate' => 5, 'years' => 3, 'n' => 4],
        'Example B' => ['principal' => 5000, 'rate' => 6.5, 'years' => 5, 'n' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Interest earned'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>MV = P(1 + r/n)^(nt)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
