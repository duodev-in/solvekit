<x-calc.page
    title="Bill Rate Calculator - SolveKit"
    description="Free bill rate calculator: the hourly bill rate for a contractor or staffing placement from the pay rate, burden and target margin."
    lede="Set a bill rate from pay, burden and margin."
    about="Loaded cost = pay rate × (1 + burden), where burden covers payroll taxes, insurance and benefits (often 20–35%). Bill rate = cost ÷ (1 − gross margin). Markup = bill ÷ pay − 1. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'bill_rate', 'fields' => ['pay', 'burden', 'margin']]"
    :how-to="[
        ['name' => 'Enter the pay rate', 'text' => ''],
        ['name' => 'Enter burden and margin', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What bill rate gives a 25% margin on $40 pay with 25% burden?', 'answer' => '$66.67.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pay" label="Pay rate" value="40" step="0.01" suffix="$" />
        <x-calc.field name="burden" label="Burden" value="25" step="any" suffix="%" />
        <x-calc.field name="margin" label="Gross margin" value="25" step="any" suffix="%" />
    </div>

    <x-calc.result label="Bill rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pay' => 40, 'burden' => 25, 'margin' => 25],
        'Low margin' => ['pay' => 40, 'burden' => 25, 'margin' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cost' => ['label' => 'Loaded cost'],
            'profit' => ['label' => 'Profit per hour'],
            'markup' => ['label' => 'Markup on pay'],
            'weekly' => ['label' => 'Billed a 40-hour week'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>bill = pay × (1 + burden) ÷ (1 − margin)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
