<x-calc.page
    title="Salary Calculator With Overtime - SolveKit"
    description="Free salary with overtime calculator: annual and monthly pay from an hourly rate, regular hours and overtime hours."
    lede="Work out your salary including overtime."
    about="Overtime hours are paid at 1.5× the hourly rate under the FLSA. Yearly pay = (regular pay + overtime pay) a week × weeks worked. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'hourly_ot_salary', 'fields' => ['rate', 'hours', 'ot_hours', 'weeks']]"
    :how-to="[
        ['name' => 'Enter rate and hours', 'text' => ''],
        ['name' => 'Add overtime', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the salary at $20 an hour with 10 overtime hours for 50 weeks?', 'answer' => '$55,000.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Hourly rate" value="20" step="0.01" suffix="$" />
        <x-calc.field name="hours" label="Regular hours a week" value="40" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ot_hours" label="Overtime hours a week" value="10" min="0" step="any" />
        <x-calc.field name="weeks" label="Weeks a year" value="50" min="1" max="52" step="any" />
    </div>

    <x-calc.result label="Yearly pay with overtime" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['rate' => 20, 'hours' => 40, 'ot_hours' => 10, 'weeks' => 50],
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
