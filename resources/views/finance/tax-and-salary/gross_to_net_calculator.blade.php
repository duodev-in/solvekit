<x-calc.page
    title="Gross to Net Calculator - SolveKit"
    description="Free gross to net paycheck calculator for 2026: take-home pay after federal and state income tax, Social Security, Medicare and pre-tax deductions, for any pay frequency."
    lede="Work out your take-home pay from your gross pay."
    about="Federal income tax is estimated on annualized taxable wages (after 401(k) and pre-tax deductions and the 2026 standard deduction) using the 2026 brackets and child tax credit, then spread over your paychecks. FICA is 6.2% Social Security up to $184,500 and 1.45% Medicare (+0.9% over $200,000). State tax uses the 2026 state tables. Your actual withholding depends on your W-4, so expect some difference. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'paycheck', 'fields' => ['pay_basis', 'salary', 'hourly', 'hours', 'amount', 'periods', 'status', 'state', 'children', 'pretax_pct', 'pretax', 'post'], 'data' => ['federal' => config('finance_data.federal'), 'states' => config('finance_data.states')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter your pay', 'text' => 'Salary, hourly or per paycheck.'],
        ['name' => 'Set your state, status and deductions', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the take-home pay on $75,000 in California paid every two weeks?', 'answer' => '$2,098.41 a paycheck.'],
        ['question' => 'And in Texas?', 'answer' => '$2,186.09 (no state income tax).'],
        ['question' => 'How much goes to Social Security?', 'answer' => '$172.65 a paycheck.'],
    ]"
>
    <x-calc.segmented name="pay_basis" legend="Pay entered as" :options="['salary' => 'Yearly salary', 'hourly' => 'Hourly', 'period' => 'Per paycheck']" selected="salary" />

    <div data-show-when="pay_basis:salary">
        <x-calc.field name="salary" label="Yearly salary" value="75000" step="0.01" suffix="$" />
    </div>

    <div data-show-when="pay_basis:hourly" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="hourly" label="Hourly rate" value="30" step="0.01" suffix="$" />
            <x-calc.field name="hours" label="Hours a week" value="40" min="0" step="any" />
        </div>
    </div>

    <div data-show-when="pay_basis:period" hidden>
        <x-calc.field name="amount" label="Gross per paycheck" value="3000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="periods" label="Pay frequency" :options="['52' => 'Weekly', '26' => 'Every two weeks', '24' => 'Twice a month', '12' => 'Monthly']" selected="26" />
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="state" label="State" :options="['AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming']" selected="CA" />
        <x-calc.field name="children" label="Children under 17" value="0" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pretax_pct" label="401(k) contribution" value="5" step="any" suffix="%" />
        <x-calc.field name="pretax" label="Health and other pre-tax deductions per paycheck" value="100" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="post" label="After-tax deductions per paycheck" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Take-home pay" />

    <x-calc.options :decimals="false" :examples="[
        'California $75k' => ['pay_basis' => 'salary', 'salary' => 75000, 'hourly' => '', 'hours' => '', 'amount' => '', 'periods' => '26', 'status' => 'single', 'state' => 'CA', 'children' => 0, 'pretax_pct' => 5, 'pretax' => 100, 'post' => 0],
        'Texas $75k' => ['pay_basis' => 'salary', 'salary' => 75000, 'hourly' => '', 'hours' => '', 'amount' => '', 'periods' => '26', 'status' => 'single', 'state' => 'TX', 'children' => 0, 'pretax_pct' => 5, 'pretax' => 100, 'post' => 0],
        'Family in New York' => ['pay_basis' => 'salary', 'salary' => 140000, 'hourly' => '', 'hours' => '', 'amount' => '', 'periods' => '24', 'status' => 'mfj', 'state' => 'NY', 'children' => 2, 'pretax_pct' => 6, 'pretax' => 250, 'post' => 0],
        '$25 an hour' => ['pay_basis' => 'hourly', 'salary' => '', 'hourly' => 25, 'hours' => 40, 'amount' => '', 'periods' => '52', 'status' => 'single', 'state' => 'OH', 'children' => 0, 'pretax_pct' => 0, 'pretax' => 0, 'post' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gross' => ['label' => 'Gross pay'],
            'federal' => ['label' => 'Federal income tax'],
            'ss' => ['label' => 'Social Security'],
            'medicare' => ['label' => 'Medicare'],
            'state' => ['label' => 'State income tax'],
            'pretax' => ['label' => 'Pre-tax deductions'],
            'effective' => ['label' => 'Taxes as a share of pay'],
            'marginal' => ['label' => 'Marginal rate'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>net = gross − pre-tax − federal − FICA − state − after-tax</li>
            <li>federal = brackets(annual taxable) − credits</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
