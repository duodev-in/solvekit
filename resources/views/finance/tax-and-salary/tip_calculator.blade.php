<x-calc.page
    title="Tip Calculator - SolveKit"
    description="Free tip calculator: tip and total for a bill at any percentage, split between people, with rounding up and tipping on the pre-tax amount."
    lede="Work out the tip and split the bill."
    about="Tip = bill × tip %. In the US 15–20% is usual for table service; some people tip on the amount before sales tax. Split = total ÷ people. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-pay', 'tool' => 'tip', 'fields' => ['bill', 'tip', 'people', 'on', 'tax', 'round']]"
    :how-to="[
        ['name' => 'Enter the bill and tip %', 'text' => ''],
        ['name' => 'Split it', 'text' => 'And round if you like.'],
    ]"
    :faqs="[
        ['question' => 'What is an 18% tip on $86.40?', 'answer' => '$15.55; each of 2 pays $50.98.'],
        ['question' => 'And 20% split four ways, rounded up?', 'answer' => 'Each pays $64.00.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bill" label="Bill" value="86.4" step="0.01" suffix="$" />
        <x-calc.field name="tip" label="Tip" value="18" step="any" suffix="%" />
        <x-calc.field name="people" label="People" value="2" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="on" label="Tip on" :options="['total' => 'Total bill', 'pretax' => 'Amount before tax']" selected="total" />
        <x-calc.field name="tax" label="Sales tax in the bill" value="8" step="any" suffix="%" />
        <x-calc.select name="round" label="Round the total" :options="['none' => 'No', 'up' => 'Up to the next dollar']" selected="none" />
    </div>

    <x-calc.result label="Tip" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bill' => 86.4, 'tip' => 18, 'people' => 2, 'on' => 'total', 'tax' => 8, 'round' => 'none'],
        'Group' => ['bill' => 212.75, 'tip' => 20, 'people' => 4, 'on' => 'total', 'tax' => 8, 'round' => 'up'],
        'Pre-tax tip' => ['bill' => 54, 'tip' => 20, 'people' => 1, 'on' => 'pretax', 'tax' => 8, 'round' => 'none'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total'],
            'each' => ['label' => 'Each person pays'],
            'tip_each' => ['label' => 'Tip per person'],
            'rate' => ['label' => 'Effective tip rate'],
        ]" />
        <x-calc.quick-ref heading="Tip guide" name="guide" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>tip = bill × %</li>
            <li>each = (bill + tip) ÷ people</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
