<x-calc.page
    title="Lifetime Earnings Calculator - SolveKit"
    description="Free Lifetime Earnings Calculator: Σ salary × (1 + g)^t = salary × [(1 + g)^n − 1] ÷ g. Total earnings over a career with a steady yearly raise."
    lede="Work out the lifetime earnings from starting salary, average raise a year and working years."
    about="Total earnings over a career with a steady yearly raise. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'lifetime_earnings', 'fields' => ['salary', 'raise', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Starting salary, Average raise a year, Working years.'],
        ['name' => 'Read the result', 'text' => 'The lifetime earnings appears as you type, with final salary below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the lifetime earnings?', 'answer' => 'Σ salary × (1 + g)^t = salary × [(1 + g)^n − 1] ÷ g.'],
        ['question' => 'What is the lifetime earnings for starting salary $50,000, average raise a year 3%, working years 40?', 'answer' => '$3,770,062.99. Final salary: $158,351.35.'],
        ['question' => 'And for starting salary $72,000, average raise a year 2%, working years 30?', 'answer' => '$2,920,901.70. Final salary: $127,860.82.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Inflation is included in the raise; real earnings grow slower.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="salary" label="Starting salary" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="raise" label="Average raise a year" value="3" step="any" suffix="%" />
        <x-calc.field name="years" label="Working years" value="40" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Lifetime earnings" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['salary' => 50000, 'raise' => 3, 'years' => 40],
        'Example B' => ['salary' => 72000, 'raise' => 2, 'years' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Final salary'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ salary × (1 + g)^t = salary × [(1 + g)^n − 1] ÷ g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
