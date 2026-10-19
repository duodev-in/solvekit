<x-calc.page
    title="Georgia Overtime Calculator - SolveKit"
    description="Free Georgia overtime calculator: federal FLSA rules, 1.5× for hours over 40 a week."
    lede="Work out overtime pay in Georgia."
    about="The Fair Labor Standards Act requires 1.5× the regular rate for hours over 40 in a workweek for non-exempt employees. It does not require daily overtime, weekend or holiday premiums. Georgia has no state overtime rule that goes further for most workers, so the federal rule applies. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'overtime', 'fields' => ['rate', 'worked', 'multiplier'], 'rules' => 'federal']"
    :how-to="[
        ['name' => 'Enter your rate', 'text' => ''],
        ['name' => 'Enter your hours', 'text' => 'Per week, or per day under California rules.'],
    ]"
    :faqs="[
        ['question' => 'What is pay for 48 hours at $22 an hour?', 'answer' => '$1,144.00: $264.00 at $33.00 an hour of overtime.'],
        ['question' => 'And 55 hours at $18?', 'answer' => '$1,125.00.'],
        ['question' => 'Do salaried workers get overtime?', 'answer' => 'Only if non-exempt; most salaried employees earning over the federal threshold who pass the duties tests are exempt.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rate" label="Hourly rate" value="22" step="0.01" suffix="$" />
        <x-calc.field name="worked" label="Hours worked this week" value="48" min="0" step="any" />
        <x-calc.field name="multiplier" label="Overtime multiplier" value="1.5" min="1" step="0.5" />
    </div>

    <x-calc.result label="Gross pay for the week" />

    <x-calc.options :decimals="false" :examples="[
        '48 hours' => ['rate' => 22, 'worked' => 48, 'multiplier' => 1.5],
        '55 hours' => ['rate' => 18, 'worked' => 55, 'multiplier' => 1.5],
        'No overtime' => ['rate' => 30, 'worked' => 38, 'multiplier' => 1.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'regular' => ['label' => 'Regular pay'],
            'overtime' => ['label' => 'Overtime pay'],
            'double' => ['label' => 'Double time'],
            'average' => ['label' => 'Average per hour'],
            'rules' => ['label' => 'Rules'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pay = regular × rate + OT × rate × 1.5 (+ DT × rate × 2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
