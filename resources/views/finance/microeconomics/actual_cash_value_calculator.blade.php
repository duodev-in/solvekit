<x-calc.page
    title="Actual Cash Value Calculator - SolveKit"
    description="Free Actual Cash Value Calculator: ACV = replacement cost × (1 − age ÷ useful life). Insurers pay actual cash value, replacement cost less depreciation, unless the policy covers replacement cost."
    lede="Work out the actual cash value from replacement cost, age and useful life."
    about="Insurers pay actual cash value, replacement cost less depreciation, unless the policy covers replacement cost. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'actual_cash_value', 'fields' => ['cost', 'age', 'life']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Replacement cost, Age, Useful life.'],
        ['name' => 'Read the result', 'text' => 'The actual cash value appears as you type, with depreciation below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the actual cash value?', 'answer' => 'ACV = replacement cost × (1 − age ÷ useful life).'],
        ['question' => 'What is the actual cash value for replacement cost $2,000, age 4 years, useful life 10 years?', 'answer' => '$1,200.00. Depreciation: $800.00.'],
        ['question' => 'And for replacement cost $1,200, age 3 years, useful life 8 years?', 'answer' => '$750.00. Depreciation: $450.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Policies and adjusters may use other depreciation schedules.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cost" label="Replacement cost" value="2000" step="0.01" suffix="$" />
        <x-calc.field name="age" label="Age" value="4" min="0" step="any" suffix="years" />
        <x-calc.field name="life" label="Useful life" value="10" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Actual cash value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cost' => 2000, 'age' => 4, 'life' => 10],
        'Example B' => ['cost' => 1200, 'age' => 3, 'life' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Depreciation'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ACV = replacement cost × (1 − age ÷ useful life)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
