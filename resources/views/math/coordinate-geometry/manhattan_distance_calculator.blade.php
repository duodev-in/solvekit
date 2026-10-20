<x-calc.page
    title="Manhattan Distance Calculator - SolveKit"
    description="Free Manhattan distance calculator: the taxicab distance Σ|pᵢ − qᵢ| between two points in any dimension."
    lede="Find the Manhattan distance."
    about="The Manhattan (taxicab, L1) distance adds the absolute differences of the coordinates, like walking a city grid: (1, 2) to (4, 6) is 3 + 4 = 7 blocks, while the straight line is 5. Also known as taxicab distance calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'distance', 'fields' => ['p', 'q'], 'mode' => 'vector', 'metric' => 'manhattan']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the Manhattan distance from (1, 2) to (4, 6)?', 'answer' => '7.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="Point p" value="1, 2" type="text" inputmode="text" />
        <x-calc.field name="q" label="Point q" value="4, 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Manhattan distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => '1, 2', 'q' => '4, 6'],
        '4D' => ['p' => '1, 2, 3, 4', 'q' => '2, 4, 6, 8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'euclid' => ['label' => 'Euclidean distance'],
            'manhattan' => ['label' => 'Manhattan distance'],
            'chebyshev' => ['label' => 'Chebyshev distance'],
            'squared' => ['label' => 'Distance squared'],
            'diffs' => ['label' => 'Differences'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = Σ|pᵢ − qᵢ|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
