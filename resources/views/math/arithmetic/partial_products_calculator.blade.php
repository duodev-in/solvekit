<x-calc.page
    title="Partial Products Calculator - SolveKit"
    description="Free partial products calculator: multiply by splitting both numbers into place values and adding every partial product."
    lede="Multiply with partial products."
    about="Split each number by place value (47 = 40 + 7, 23 = 20 + 3), multiply every pair (800, 120, 140, 21) and add them: 1081. It shows why long multiplication works."
    :calc="['engine' => 'mt-arith', 'tool' => 'long_mult', 'fields' => ['a', 'b'], 'partial' => true]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 47 × 23 with partial products?', 'answer' => '1,081.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First number" value="47" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Second number" value="23" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Product" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '47', 'b' => '23'],
        'Three digits' => ['a' => '312', 'b' => '45'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'exact' => ['label' => 'Exact product'],
            'columns' => ['label' => 'Partial products'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(a₁ + a₂)(b₁ + b₂) = Σ aᵢbⱼ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
