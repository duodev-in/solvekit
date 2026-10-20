<x-calc.page
    title="Sum of a Linear Number Sequence Calculator - SolveKit"
    description="Free sum of a linear sequence calculator: add an arithmetic run from its first term, last term and number of terms."
    lede="Add up a linear sequence."
    about="A linear sequence goes up by the same step. Its sum is the number of terms times the average of the first and last: 1 + 2 + … + 100 = 100 × 101/2 = 5,050."
    :calc="['engine' => 'mt-seq', 'tool' => 'linear_sum', 'fields' => ['first', 'last', 'count']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is 1 + 2 + … + 100?', 'answer' => '5,050.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="first" label="First term" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="last" label="Last term" value="100" type="text" inputmode="decimal" />
        <x-calc.field name="count" label="Number of terms" value="100" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Sum" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['first' => '1', 'last' => '100', 'count' => '100'],
        'Odds' => ['first' => '1', 'last' => '99', 'count' => '50'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'd' => ['label' => 'Common difference'],
            'mean' => ['label' => 'Average term'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>S = n(first + last)/2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
