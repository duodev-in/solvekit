<x-calc.page
    title="Euclidean Distance Calculator - SolveKit"
    description="Free Euclidean distance calculator: the straight-line distance between two points in any number of dimensions."
    lede="Find the Euclidean distance."
    about="The Euclidean distance generalises Pythagoras to n dimensions: d = √Σ(pᵢ − qᵢ)². It is the ordinary straight-line distance and the usual metric in clustering and nearest-neighbour methods."
    :calc="['engine' => 'mt-coord', 'tool' => 'distance', 'fields' => ['p', 'q'], 'mode' => 'vector']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the Euclidean distance between (1, 2, 3, 4) and (2, 4, 6, 8)?', 'answer' => '√30.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="p" label="Point p" value="1, 2, 3, 4" type="text" inputmode="text" />
        <x-calc.field name="q" label="Point q" value="2, 4, 6, 8" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['p' => '1, 2, 3, 4', 'q' => '2, 4, 6, 8'],
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
            <li>d = √Σ(pᵢ − qᵢ)²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
