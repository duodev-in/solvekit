<x-calc.page
    title="EAR Calculator - SolveKit"
    description="Free EAR Calculator: EAR = (1 + r/n)^n − 1. The effective annual rate includes the effect of compounding within the year, so loans and deposits with different compounding can be compared."
    lede="Work out the effective annual rate from nominal annual rate and compounding periods a year."
    about="The effective annual rate includes the effect of compounding within the year, so loans and deposits with different compounding can be compared. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ear', 'fields' => ['rate', 'n']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal annual rate, Compounding periods a year.'],
        ['name' => 'Read the result', 'text' => 'The effective annual rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the effective annual rate?', 'answer' => 'EAR = (1 + r/n)^n − 1.'],
        ['question' => 'What is the effective annual rate for nominal annual rate 12%, compounding periods a year 12?', 'answer' => '12.68%.'],
        ['question' => 'And for nominal annual rate 6%, compounding periods a year 4?', 'answer' => '6.136%.'],
        ['question' => 'What does the result tell me?', 'answer' => '12% compounded monthly is 12.68% effective.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Nominal annual rate" value="12" step="any" suffix="%" />
        <x-calc.field name="n" label="Compounding periods a year" value="12" min="0" step="1" />
    </div>

    <x-calc.result label="Effective annual rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rate' => 12, 'n' => 12],
        'Example B' => ['rate' => 6, 'n' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EAR = (1 + r/n)^n − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
