<x-calc.page
    title="Payroll Cost per Employee Calculator - SolveKit"
    description="Free payroll cost per employee calculator: salary plus employer FICA (7.65% to the 2026 wage base), FUTA, state unemployment, benefits and retirement match."
    lede="Find the total cost of an employee."
    about="Employer costs on top of salary: Social Security 6.2% up to $184,500 and Medicare 1.45% (2026), federal unemployment tax 0.6% of the first $7,000 (after the state credit), state unemployment at your rate and wage base, benefits and any 401(k) match. Totals are often 1.25–1.4× salary. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'payroll_cost', 'fields' => ['salary', 'suta', 'suta_base', 'benefits', 'match', 'other'], 'data' => ['federal' => config('finance_data.federal')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the salary', 'text' => ''],
        ['name' => 'Add taxes and benefits', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does a $70,000 employee cost in total?', 'answer' => '$87,786.00 (1.254× the salary).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="salary" label="Salary" value="70000" step="0.01" suffix="$" />
        <x-calc.field name="suta" label="State unemployment rate" value="2.7" step="any" suffix="%" />
        <x-calc.field name="suta_base" label="State wage base" value="7000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="benefits" label="Benefits a month" value="700" step="0.01" suffix="$" />
        <x-calc.field name="match" label="401(k) match" value="4" step="any" suffix="%" />
        <x-calc.field name="other" label="Other yearly costs" value="1000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Total cost per employee a year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['salary' => 70000, 'suta' => 2.7, 'suta_base' => 7000, 'benefits' => 700, 'match' => 4, 'other' => 1000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fica' => ['label' => 'Employer FICA'],
            'unemployment' => ['label' => 'FUTA and SUTA'],
            'benefits' => ['label' => 'Benefits and match'],
            'monthly' => ['label' => 'A month'],
            'hourly' => ['label' => 'Per paid hour'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cost = salary + FICA + FUTA + SUTA + benefits + match</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
