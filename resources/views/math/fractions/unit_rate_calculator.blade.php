<x-calc.page
    title="Unit Rate Calculator - SolveKit"
    description="Free unit rate calculator: the amount per one unit (price per item, miles per hour, words per minute) and its inverse."
    lede="Find a unit rate."
    about="A unit rate is a ratio with 1 in the second term: 150 miles in 3 hours is 50 miles per hour. It makes offers comparable: 12 for $4.80 is $0.40 each."
    :calc="['engine' => 'mt-frac', 'tool' => 'unit_rate', 'fields' => ['amount', 'per', 'unitA', 'unitB']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the rate for 150 miles in 3 hours?', 'answer' => '50 miles per hour.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="150" type="text" inputmode="decimal" />
        <x-calc.field name="per" label="Per quantity" value="3" type="text" inputmode="decimal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="unitA" label="Amount unit" value="miles" type="text" inputmode="text" />
        <x-calc.field name="unitB" label="Quantity unit" value="hour" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Unit rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['amount' => '150', 'per' => '3', 'unitA' => 'miles', 'unitB' => 'hour'],
        'Price' => ['amount' => '4.80', 'per' => '12', 'unitA' => 'dollars', 'unitB' => 'item'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'inverse' => ['label' => 'Inverse rate'],
            'per100' => ['label' => 'Per 100'],
            'fraction' => ['label' => 'Exact'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>rate = amount ÷ quantity</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
