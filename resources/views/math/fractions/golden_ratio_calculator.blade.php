<x-calc.page
    title="Golden Ratio Calculator - SolveKit"
    description="Free golden ratio calculator: split a length in the golden ratio φ ≈ 1.618, or find the other side from one side."
    lede="Work with the golden ratio."
    about="Two lengths a > b are in the golden ratio when (a + b) ÷ a = a ÷ b = φ = (1 + √5) ÷ 2 ≈ 1.6180339887. It appears in pentagons, the Fibonacci sequence and design grids."
    :calc="['engine' => 'mt-frac', 'tool' => 'golden', 'fields' => ['value', 'known']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Fractions (3/4), mixed numbers (1 1/2) and decimals all work.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'How is 100 split in the golden ratio?', 'answer' => 'a = 61.80339887, b = 38.19660113.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="value" label="Known length" value="100" step="any" />
        <x-calc.select name="known" label="It is" :options="['total' => 'The whole a + b', 'a' => 'The longer part a', 'b' => 'The shorter part b']" selected="total" />
    </div>

    <x-calc.result label="Golden ratio lengths" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['value' => 100, 'known' => 'total'],
        'From a side' => ['value' => 10, 'known' => 'a'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Longer part a'],
            'b' => ['label' => 'Shorter part b'],
            'total' => ['label' => 'Whole a + b'],
            'phi' => ['label' => 'φ'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>φ = (1 + √5)/2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
