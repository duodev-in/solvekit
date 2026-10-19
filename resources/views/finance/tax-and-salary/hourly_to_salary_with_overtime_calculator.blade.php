<x-calc.page
    title="Hourly to Salary with Overtime Calculator - SolveKit"
    description="Free hourly to salary with overtime calculator: yearly pay from an hourly rate including regular overtime at 1.5×."
    lede="Turn hourly pay with overtime into a salary."
    about="Weekly pay = 40 × rate + overtime hours × rate × 1.5; yearly = weekly × weeks worked. Hours over 40 entered as regular hours are counted as overtime. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'hourly_ot_salary', 'fields' => ['rate', 'hours', 'ot_hours', 'weeks']]"
    :how-to="[
        ['name' => 'Enter rate and hours', 'text' => ''],
        ['name' => 'Add overtime hours', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the yearly pay at $24 an hour with 6 hours overtime a week?', 'answer' => '$61,152.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Hourly rate" value="24" step="0.01" suffix="$" />
        <x-calc.field name="hours" label="Regular hours a week" value="40" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ot_hours" label="Overtime hours a week" value="6" min="0" step="any" />
        <x-calc.field name="weeks" label="Weeks a year" value="52" min="1" max="52" step="any" />
    </div>

    <x-calc.result label="Yearly pay with overtime" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rate' => 24, 'hours' => 40, 'ot_hours' => 6, 'weeks' => 52],
        'No overtime' => ['rate' => 24, 'hours' => 40, 'ot_hours' => 0, 'weeks' => 52],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'base' => ['label' => 'Base pay'],
            'overtime' => ['label' => 'Overtime pay'],
            'monthly' => ['label' => 'Monthly'],
            'effective' => ['label' => 'Average hourly'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>yearly = (40r + 1.5r × OT) × weeks</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
