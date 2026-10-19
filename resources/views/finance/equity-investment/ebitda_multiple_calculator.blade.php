<x-calc.page
    title="EBITDA Multiple Calculator - SolveKit"
    description="Free EBITDA Multiple Calculator: multiple = EV ÷ EBITDA. The EBITDA multiple values a whole company against its operating cash earnings, regardless of debt."
    lede="Work out the EV/EBITDA from enterprise value and EBITDA."
    about="The EBITDA multiple values a whole company against its operating cash earnings, regardless of debt. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ebitda_multiple', 'fields' => ['ev', 'ebitda']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Enterprise value, EBITDA.'],
        ['name' => 'Read the result', 'text' => 'The EV/EBITDA appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EV/EBITDA?', 'answer' => 'Multiple = EV ÷ EBITDA.'],
        ['question' => 'What is the EV/EBITDA for enterprise value $50,000,000, EBITDA $6,250,000?', 'answer' => '8×.'],
        ['question' => 'And for enterprise value $120,000,000, EBITDA $9,600,000?', 'answer' => '12.5×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with similar companies; typical multiples differ by industry.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ev" label="Enterprise value" value="50000000" step="0.01" suffix="$" />
        <x-calc.field name="ebitda" label="EBITDA" value="6250000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="EV/EBITDA" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ev' => 50000000, 'ebitda' => 6250000],
        'Example B' => ['ev' => 120000000, 'ebitda' => 9600000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>multiple = EV ÷ EBITDA</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
