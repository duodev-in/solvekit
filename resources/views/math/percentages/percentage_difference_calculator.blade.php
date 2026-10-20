<x-calc.page
    title="Percentage Difference Calculator - SolveKit"
    description="Free percentage difference calculator: the difference between two values as a percentage of their average, compared with percentage change."
    lede="Find the percentage difference between two numbers."
    about="Percentage difference compares two values with no “before” and “after”: |a − b| ÷ ((a + b) ÷ 2) × 100. It is symmetric, so the order does not matter. Use percentage change when one value is the starting point."
    :calc="['engine' => 'mt-percent', 'tool' => 'difference', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter both values', 'text' => 'The order does not matter.'],
    ]"
    :faqs="[
        ['question' => 'What is the percentage difference between 40 and 60?', 'answer' => '40%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Value A" value="40" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Value B" value="60" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Percentage difference" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '40', 'b' => '60'],
        'Close values' => ['a' => '9.8', 'b' => '10.2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'absolute' => ['label' => 'Absolute difference'],
            'mean' => ['label' => 'Average'],
            'change' => ['label' => 'Percentage change instead'],
            'formula' => ['label' => 'Formula'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|a − b| ÷ ((a + b)/2) × 100</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
