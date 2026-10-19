<x-calc.page
    title="Effective Annual Yield Calculator - SolveKit"
    description="Free Effective Annual Yield Calculator: EAY = (1 + r/n)^n − 1. Effective annual yield is the yearly yield including compounding, for example of a semi-annual coupon bond."
    lede="Work out the effective annual yield from nominal yield and compounding periods a year."
    about="Effective annual yield is the yearly yield including compounding, for example of a semi-annual coupon bond. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'effective_annual_yield', 'fields' => ['rate', 'n']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal yield, Compounding periods a year.'],
        ['name' => 'Read the result', 'text' => 'The effective annual yield appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the effective annual yield?', 'answer' => 'EAY = (1 + r/n)^n − 1.'],
        ['question' => 'What is the effective annual yield for nominal yield 5%, compounding periods a year 2?', 'answer' => '5.062%.'],
        ['question' => 'And for nominal yield 7.2%, compounding periods a year 12?', 'answer' => '7.442%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A 5% bond yield compounded semi-annually is 5.06% effective.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Nominal yield" value="5" step="any" suffix="%" />
        <x-calc.field name="n" label="Compounding periods a year" value="2" min="0" step="1" />
    </div>

    <x-calc.result label="Effective annual yield" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rate' => 5, 'n' => 2],
        'Example B' => ['rate' => 7.2, 'n' => 12],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EAY = (1 + r/n)^n − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
