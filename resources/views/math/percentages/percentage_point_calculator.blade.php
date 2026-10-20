<x-calc.page
    title="Percentage Point Calculator - SolveKit"
    description="Free percentage point calculator: the change between two percentages in percentage points, and the relative change in percent."
    lede="Find the change in percentage points."
    about="A percentage point is the arithmetic difference between two percentages: an interest rate rising from 3% to 5% rises by 2 percentage points, which is a 66.7% increase in the rate. Mixing the two causes many misleading headlines."
    :calc="['engine' => 'mt-percent', 'tool' => 'points', 'fields' => ['a', 'b']]"
    :how-to="[
        ['name' => 'Enter the two percentages', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the change from 3% to 5%?', 'answer' => '+2 pp (A relative change of 66.(6)%).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="First percentage" value="3" type="text" suffix="%" inputmode="decimal" />
        <x-calc.field name="b" label="Second percentage" value="5" type="text" suffix="%" inputmode="decimal" />
    </div>

    <x-calc.result label="Percentage-point change" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '3', 'b' => '5'],
        'Fall' => ['a' => '42', 'b' => '38'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'points' => ['label' => 'Percentage points'],
            'relative' => ['label' => 'Relative change'],
            'note' => ['label' => 'Difference'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>pp = p₂ − p₁</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
