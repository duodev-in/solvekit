<x-calc.page
    title="California Overtime Calculator - SolveKit"
    description="Free California overtime calculator: daily overtime over 8 hours, double time over 12, weekly overtime over 40 and seventh-day rules."
    lede="Work out overtime under California rules."
    about="California Labor Code §510: 1.5× for hours over 8 in a day or 40 in a week, and for the first 8 hours on the seventh consecutive workday; 2× for hours over 12 in a day and over 8 on the seventh day. Enter hours for each day of the workweek. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'overtime', 'fields' => ['rate', 'multiplier', 'daily'], 'rules' => 'california']"
    :how-to="[
        ['name' => 'Enter your rate', 'text' => ''],
        ['name' => 'Enter your hours', 'text' => 'Per week, or per day under California rules.'],
    ]"
    :faqs="[
        ['question' => 'What is pay for 10, 9, 13, 8 and 8 hours at $25?', 'answer' => '$1,312.50 with $50.00 at $50.00 an hour of double time.'],
        ['question' => 'What about working seven days?', 'answer' => '$1,700.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Hourly rate" value="25" step="0.01" suffix="$" />
        <x-calc.field name="multiplier" label="Overtime multiplier" value="1.5" min="1" step="0.5" />
    </div>

    <x-calc.textarea name="daily" label="Hours each day of the week (Monday first, up to 7 days)" value="10, 9, 13, 8, 8, 0, 0" rows="2" />

    <x-calc.result label="Gross pay for the week" />

    <x-calc.options :decimals="false" :examples="[
        'Long days' => ['rate' => 25, 'multiplier' => 1.5, 'daily' => '10, 9, 13, 8, 8, 0, 0'],
        'Seven days' => ['rate' => 25, 'multiplier' => 1.5, 'daily' => '8, 8, 8, 8, 8, 8, 10'],
        'Four tens' => ['rate' => 30, 'multiplier' => 1.5, 'daily' => '10, 10, 10, 10, 0, 0, 0'],
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
