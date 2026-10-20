<x-calc.page
    title="Sum of Products Calculator - SolveKit"
    description="Free sum of products calculator: Σ aᵢ × bᵢ of two lists (the dot product of lists, SUMPRODUCT)."
    lede="Add up pairwise products."
    about="The sum of products multiplies matching entries of two lists and adds the results, like a spreadsheet SUMPRODUCT: prices × quantities give a total bill."
    :calc="['engine' => 'mt-number', 'tool' => 'sum_products', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 2×4 + 3×1 + 5×6?', 'answer' => '41.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="a" label="First list" value="2, 3, 5" rows="3" />
        <x-calc.textarea name="b" label="Second list" value="4, 1, 6" rows="3" />
    </div>

    <x-calc.result label="Σ aᵢbᵢ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '2, 3, 5', 'b' => '4, 1, 6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Pairs'],
            'sumA' => ['label' => 'Sum of the first list'],
            'sumB' => ['label' => 'Sum of the second list'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Σ aᵢbᵢ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
