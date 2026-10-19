<x-calc.page
    title="Burn Rate Calculator - SolveKit"
    description="Free burn rate calculator: gross and net monthly burn and cash runway for a startup."
    lede="Work out your burn rate and runway."
    about="Gross burn = monthly operating expenses; net burn = expenses − revenue. Runway = cash ÷ net burn. Investors often advise raising when 9–12 months of runway remain. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'burn_rate', 'fields' => ['cash', 'expenses', 'revenue']]"
    :how-to="[
        ['name' => 'Enter cash', 'text' => ''],
        ['name' => 'Enter monthly expenses and revenue', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long do $1.2M last at $150,000 a month of costs and $50,000 of revenue?', 'answer' => '12 months.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="cash" label="Cash in the bank" value="1200000" step="0.01" suffix="$" />
        <x-calc.field name="expenses" label="Monthly expenses" value="150000" step="0.01" suffix="$" />
        <x-calc.field name="revenue" label="Monthly revenue" value="50000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Runway" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cash' => 1200000, 'expenses' => 150000, 'revenue' => 50000],
        'No revenue' => ['cash' => 500000, 'expenses' => 60000, 'revenue' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'gross' => ['label' => 'Gross burn'],
            'net' => ['label' => 'Net burn'],
            'date' => ['label' => 'Full months of cash'],
            'raise' => ['label' => 'To fund 18 months'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>runway = cash ÷ (expenses − revenue)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
