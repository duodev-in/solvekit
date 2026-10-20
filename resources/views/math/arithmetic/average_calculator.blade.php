<x-calc.page
    title="Average Calculator - SolveKit"
    description="Free average calculator: the mean, median, mode and range of a list of numbers."
    lede="Find the average of a list."
    about="The mean adds the numbers and divides by how many there are; the median is the middle value when sorted; the mode is the most common value. Exact fractions keep the mean exact (the mean of 1, 2 and 2 is 5/3)."
    :calc="['engine' => 'mt-number', 'tool' => 'stats', 'fields' => ['list'], 'kind' => 'mean']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the average of 4, 8, 15, 16, 23 and 42?', 'answer' => '18.'],
    ]"
>
    <x-calc.textarea name="list" label="Numbers" value="4, 8, 15, 16, 23, 42" rows="3" />

    <x-calc.result label="Mean (average)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['list' => '4, 8, 15, 16, 23, 42'],
        'With mode' => ['list' => '3, 7, 7, 2, 9, 7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mean' => ['label' => 'Mean'],
            'median' => ['label' => 'Median'],
            'mode' => ['label' => 'Mode'],
            'range' => ['label' => 'Range'],
            'sum' => ['label' => 'Sum'],
            'count' => ['label' => 'Count'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>mean = Σx ÷ n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
