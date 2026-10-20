<x-calc.page
    title="Reverse Percentage Calculator - SolveKit"
    description="Free reverse percentage calculator: find the original value before a percentage increase or decrease (prices before VAT or a discount)."
    lede="Find the original value before a percentage change."
    about="If a value grew by p% to reach F, the original was F ÷ (1 + p/100); after a decrease it was F ÷ (1 − p/100). For example, a price of 120 including 20% tax was 100 before tax, not 96."
    :calc="['engine' => 'mt-percent', 'tool' => 'reverse', 'fields' => ['final', 'p', 'direction']]"
    :how-to="[
        ['name' => 'Enter the final value and percentage', 'text' => ''],
        ['name' => 'Choose increase or decrease', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What was a price before 20% tax if it is 120 now?', 'answer' => '100.'],
        ['question' => 'What was the price before a 25% discount to 60?', 'answer' => '80.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="final" label="Final value" value="120" type="text" inputmode="decimal" />
        <x-calc.field name="p" label="Percentage" value="20" type="text" suffix="%" inputmode="decimal" />
        <x-calc.segmented name="direction" legend="Change" :options="['increase' => 'Increase', 'decrease' => 'Decrease']" selected="increase" />
    </div>

    <x-calc.result label="Original value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['final' => '120', 'p' => '20', 'direction' => 'increase'],
        'Discount' => ['final' => '60', 'p' => '25', 'direction' => 'decrease'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'change' => ['label' => 'Change'],
            'check' => ['label' => 'Check'],
            'fraction' => ['label' => 'Exact value'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>original = final ÷ (1 ± p/100)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
