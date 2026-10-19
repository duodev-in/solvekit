<x-calc.page
    title="New York Overtime Calculator - SolveKit"
    description="Free New York overtime calculator: 1.5× for hours over 40 a week plus spread-of-hours pay when the workday spans more than 10 hours."
    lede="Work out overtime pay in New York."
    about="New York requires 1.5× for hours over 40 in a week (over 44 for residential employees). Workers paid near minimum wage also get one extra hour at the minimum wage on days whose span exceeds 10 hours (spread of hours). The 2026 minimum wage is $17.00 in New York City, Long Island and Westchester and $16.00 elsewhere. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'overtime', 'fields' => ['rate', 'worked', 'multiplier', 'span', 'min_wage'], 'rules' => 'federal', 'spread' => true]"
    :how-to="[
        ['name' => 'Enter your rate', 'text' => ''],
        ['name' => 'Enter your hours', 'text' => 'Per week, or per day under California rules.'],
    ]"
    :faqs="[
        ['question' => 'What is pay for 48 hours at $22 an hour?', 'answer' => '$1,161.00: $264.00 at $33.00 an hour of overtime.'],
        ['question' => 'And 55 hours at $18?', 'answer' => '$1,125.00.'],
        ['question' => 'Do salaried workers get overtime?', 'answer' => 'Only if non-exempt; most salaried employees earning over the federal threshold who pass the duties tests are exempt.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Hourly rate" value="22" step="0.01" suffix="$" />
        <x-calc.field name="worked" label="Hours worked this week" value="48" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="multiplier" label="Overtime multiplier" value="1.5" min="1" step="0.5" />
        <x-calc.field name="span" label="Longest workday span (hours)" value="11" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="min_wage" label="Minimum wage" value="17" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Gross pay for the week" />

    <x-calc.options :decimals="false" :examples="[
        '48 hours' => ['rate' => 22, 'worked' => 48, 'multiplier' => 1.5, 'span' => 11, 'min_wage' => 17],
        '55 hours' => ['rate' => 18, 'worked' => 55, 'multiplier' => 1.5, 'span' => 9, 'min_wage' => 16],
        'No overtime' => ['rate' => 30, 'worked' => 38, 'multiplier' => 1.5, 'span' => 8, 'min_wage' => 16],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'regular' => ['label' => 'Regular pay'],
            'overtime' => ['label' => 'Overtime pay'],
            'double' => ['label' => 'Double time'],
            'average' => ['label' => 'Average per hour'],
            'rules' => ['label' => 'Rules'],
            'spread' => ['label' => 'Spread of hours'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pay = regular × rate + OT × rate × 1.5 (+ DT × rate × 2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
