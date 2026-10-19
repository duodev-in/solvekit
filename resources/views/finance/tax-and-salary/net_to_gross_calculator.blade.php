<x-calc.page
    title="Net to Gross Calculator - SolveKit"
    description="Free net to gross calculator: the gross pay needed for a target take-home paycheck after federal, state and FICA taxes (grossing up), 2026."
    lede="Find the gross pay for the take-home pay you want."
    about="Grossing up solves the paycheck calculation backwards: the gross pay is found numerically so that after federal tax, FICA, state tax and deductions you keep the target. Useful for bonuses and job offers. Federal income tax is estimated on annualized taxable wages (after 401(k) and pre-tax deductions and the 2026 standard deduction) using the 2026 brackets and child tax credit, then spread over your paychecks. FICA is 6.2% Social Security up to $184,500 and 1.45% Medicare (+0.9% over $200,000). State tax uses the 2026 state tables. Your actual withholding depends on your W-4, so expect some difference. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'net_to_gross', 'fields' => ['net', 'periods', 'status', 'state', 'children', 'pretax_pct', 'pretax'], 'data' => ['federal' => config('finance_data.federal'), 'states' => config('finance_data.states')], 'sym' => 'USD', 'currency' => 'USD', 'currencyFixed' => true]"
    :how-to="[
        ['name' => 'Enter the take-home you want', 'text' => ''],
        ['name' => 'Set state and status', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What gross pay gives $2,500 every two weeks in New York?', 'answer' => '$3,290.87.'],
        ['question' => 'And in Florida?', 'answer' => '$3,070.91.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="net" label="Take-home pay wanted per paycheck" value="2500" step="0.01" suffix="$" />
        <x-calc.select name="periods" label="Pay frequency" :options="['52' => 'Weekly', '26' => 'Every two weeks', '24' => 'Twice a month', '12' => 'Monthly']" selected="26" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="status" label="Filing status" :options="['single' => 'Single', 'mfj' => 'Married filing jointly', 'hoh' => 'Head of household', 'mfs' => 'Married filing separately']" selected="single" />
        <x-calc.select name="state" label="State" :options="['AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming']" selected="NY" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="children" label="Children under 17" value="0" min="0" step="1" />
        <x-calc.field name="pretax_pct" label="401(k) contribution" value="0" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pretax" label="Pre-tax deductions per paycheck" value="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Gross pay needed" />

    <x-calc.options :decimals="false" :examples="[
        'New York' => ['net' => 2500, 'periods' => '26', 'status' => 'single', 'state' => 'NY', 'children' => 0, 'pretax_pct' => 0, 'pretax' => 0],
        'Florida' => ['net' => 2500, 'periods' => '26', 'status' => 'single', 'state' => 'FL', 'children' => 0, 'pretax_pct' => 0, 'pretax' => 0],
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
            <li>solve net(gross) = target for gross</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
