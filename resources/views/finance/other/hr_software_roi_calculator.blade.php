<x-calc.page
    title="HR Software ROI Calculator - SolveKit"
    description="Free HR software ROI calculator: return on an HR or payroll system from hours saved, against subscription and setup costs."
    lede="Work out the ROI of HR software."
    about="Benefit = employees × hours saved per employee a month × 12 × hourly cost (+ other savings). Cost = per-employee subscription × 12 + setup. ROI = (benefit − cost) ÷ cost; payback = cost ÷ monthly benefit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'hr_roi', 'fields' => ['employees', 'hours', 'cost', 'price', 'setup', 'other']]"
    :how-to="[
        ['name' => 'Enter staff and time saved', 'text' => ''],
        ['name' => 'Enter price and setup', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Does an $8 per employee system pay off for 120 staff?', 'answer' => 'ROI 212.35%, payback 3.842 months.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="employees" label="Employees" value="120" min="0" step="1" />
        <x-calc.field name="hours" label="HR hours saved per employee a month" value="0.75" min="0" step="any" />
        <x-calc.field name="cost" label="Hourly cost of HR time" value="45" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Price per employee a month" value="8" step="0.01" suffix="$" />
        <x-calc.field name="setup" label="Setup cost" value="5000" step="0.01" suffix="$" />
        <x-calc.field name="other" label="Other savings a year" value="3000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="First-year ROI" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['employees' => 120, 'hours' => 0.75, 'cost' => 45, 'price' => 8, 'setup' => 5000, 'other' => 3000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'benefit' => ['label' => 'Benefit a year'],
            'cost' => ['label' => 'Cost a year'],
            'payback' => ['label' => 'Payback'],
            'hours' => ['label' => 'Hours saved'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROI = (benefit − cost) ÷ cost</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
