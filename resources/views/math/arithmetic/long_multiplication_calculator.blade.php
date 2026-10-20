<x-calc.page
    title="Long Multiplication Calculator - SolveKit"
    description="Free long multiplication calculator: multiply with partial products in rows, the standard column method."
    lede="Multiply the long way."
    about="Multiply the top number by each digit of the bottom number, shifting one place left each time, then add the rows. For decimals, multiply as whole numbers and put back the total number of decimal places."
    :calc="['engine' => 'mt-arith', 'tool' => 'long_mult', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 347 × 26 by long multiplication?', 'answer' => '9,022.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Top number" value="347" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Bottom number" value="26" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '347', 'b' => '26'],
        'Decimals' => ['a' => '4.25', 'b' => '1.3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact product'],
            'columns' => ['label' => 'Rows'],
        ]" />
        <x-calc.steps heading="Column method" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ a × digit × 10ᵏ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
