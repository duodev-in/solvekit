<x-calc.page
    title="Sequence Calculator - SolveKit"
    description="Free sequence calculator: find the rule of a number sequence (arithmetic, geometric, quadratic, polynomial or Fibonacci-like) and the next terms."
    lede="Find the pattern in a sequence."
    about="Type at least four terms. The calculator tests for a constant difference (arithmetic), constant ratio (geometric), constant second or higher differences (quadratic or polynomial) and Fibonacci-type recurrences, and then continues the sequence. Many sequences fit several rules; the simplest one is given. Also known as number sequence calculator and pattern finder."
    :calc="['engine' => 'mt-seq', 'tool' => 'detect', 'fields' => ['terms', 'more']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What comes next in 2, 5, 10, 17, 26?', 'answer' => '37, 50, 65, 82, 101.'],
        ['question' => 'And 3, 6, 12, 24?', 'answer' => '48, 96, 192.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="terms" label="Terms" value="2, 5, 10, 17, 26" type="text" inputmode="text" />
        <x-calc.field name="more" label="Next terms to show" value="5" min="1" max="30" step="1" />
    </div>

    <x-calc.result label="Rule" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['terms' => '2, 5, 10, 17, 26', 'more' => 5],
        'Geometric' => ['terms' => '3, 6, 12, 24', 'more' => 3],
        'Fibonacci-like' => ['terms' => '2, 1, 3, 4, 7, 11', 'more' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
            'next' => ['label' => 'Next terms'],
            'differences' => ['label' => 'Differences'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>finite differences</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
