<x-calc.page
    title="CAGR Calculator (Compound Annual Growth Rate) - SolveKit"
    description="Free CAGR Calculator (Compound Annual Growth Rate): CAGR = (end ÷ start)^(1/years) − 1. Compound annual growth rate is the smooth yearly growth that links two values."
    lede="Work out the CAGR from beginning value, ending value and years."
    about="Compound annual growth rate is the smooth yearly growth that links two values. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cagr', 'fields' => ['start', 'end', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Beginning value, Ending value, Years.'],
        ['name' => 'Read the result', 'text' => 'The CAGR appears as you type, with total growth, multiple below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the CAGR?', 'answer' => 'CAGR = (end ÷ start)^(1/years) − 1.'],
        ['question' => 'What is the CAGR for beginning value $1,000, ending value $2,500, years 8?', 'answer' => '12.14%. Total growth: 150%.'],
        ['question' => 'And for beginning value $120, ending value $95, years 3?', 'answer' => '−7.492%. Total growth: −20.83%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It hides the ups and downs in between.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="start" label="Beginning value" value="1000" step="0.01" suffix="$" />
        <x-calc.field name="end" label="Ending value" value="2500" step="0.01" suffix="$" />
        <x-calc.field name="years" label="Years" value="8" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="CAGR" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['start' => 1000, 'end' => 2500, 'years' => 8],
        'Example B' => ['start' => 120, 'end' => 95, 'years' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Total growth'],
            'r2' => ['label' => 'Multiple'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CAGR = (end ÷ start)^(1/years) − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
