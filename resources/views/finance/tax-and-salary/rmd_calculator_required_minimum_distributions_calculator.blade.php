<x-calc.page
    title="RMD Calculator - Required Minimum Distributions Calculator - SolveKit"
    description="Free RMD calculator: required minimum distribution from an IRA or 401(k) using the IRS Uniform Lifetime Table, with the start age under SECURE 2.0."
    lede="Work out your required minimum distribution."
    about="RMD = account balance on December 31 of last year ÷ the distribution period for your age this year (IRS Uniform Lifetime Table, in use since 2022). RMDs start at 73 for people born 1951–1959 and 75 from 1960. The penalty for a missed RMD is 25% (10% if corrected promptly). A spouse more than 10 years younger and sole beneficiary uses the Joint Life table instead. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'rmd', 'fields' => ['balance', 'age', 'born', 'rate'], 'data' => ['rmd' => config('finance_data.rmd')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the balance', 'text' => 'As of last December 31.'],
        ['name' => 'Enter your age', 'text' => 'At your birthday this year.'],
    ]"
    :faqs="[
        ['question' => 'What is the RMD on $500,000 at 75?', 'answer' => '$20,325.20.'],
        ['question' => 'And at 85?', 'answer' => '$18,750.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="balance" label="Balance on December 31 last year" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="age" label="Your age this year" value="75" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="born" label="Birth year" value="1951" min="1900" step="1" />
        <x-calc.field name="rate" label="Expected return (for next year)" value="5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Required minimum distribution" />

    <x-calc.options :decimals="false" :examples="[
        'Age 75' => ['balance' => 500000, 'age' => 75, 'born' => 1951, 'rate' => 5],
        'Age 85' => ['balance' => 300000, 'age' => 85, 'born' => 1941, 'rate' => 5],
        'First RMD' => ['balance' => 400000, 'age' => 73, 'born' => 1953, 'rate' => 5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Distribution period'],
            'start' => ['label' => 'RMD start age'],
            'deadline' => ['label' => 'Deadline'],
            'next' => ['label' => 'Next year\'s RMD (estimate)'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RMD = balance ÷ factor(age)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
