<x-calc.page
    title="Future Salary Calculator - SolveKit"
    description="Free future salary calculator: your salary after years of raises, in future and today's money."
    lede="Project your salary with yearly raises."
    about="Future salary = salary × (1 + raise)^years. Divide by (1 + inflation)^years to see its buying power today. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'future_salary', 'fields' => ['salary', 'raise_pct', 'years', 'inflation']]"
    :how-to="[
        ['name' => 'Enter salary and raise', 'text' => ''],
        ['name' => 'Enter years and inflation', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What will $60,000 be in 10 years at 3.5% raises?', 'answer' => '$84,635.93; $66,117.45 in today\'s money.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="salary" label="Current salary" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="raise_pct" label="Yearly raise" value="3.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
        <x-calc.field name="inflation" label="Inflation" value="2.5" step="any" suffix="%" />
    </div>

    <x-calc.result label="Future salary" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['salary' => 60000, 'raise_pct' => 3.5, 'years' => 10, 'inflation' => 2.5],
        'Fast growth' => ['salary' => 60000, 'raise_pct' => 7, 'years' => 10, 'inflation' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'increase' => ['label' => 'Increase'],
            'real' => ['label' => 'In today\'s money'],
            'total' => ['label' => 'Earned over the years'],
            'monthly' => ['label' => 'Monthly then'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>S = S₀(1 + g)^t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
