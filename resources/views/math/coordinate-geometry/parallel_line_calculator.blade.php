<x-calc.page
    title="Parallel Line Calculator - SolveKit"
    description="Free parallel line calculator: the line through a point parallel to a given line, with the distance between them."
    lede="Find a parallel line."
    about="Parallel lines have equal slopes. Keep the slope of the given line and pass through the new point: parallel to y = 2x + 1 through (3, 4) is y = 2x − 2."
    :calc="['engine' => 'mt-coord', 'tool' => 'parallel_perp', 'fields' => ['eq', 'px', 'py'], 'kind' => 'parallel']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What line through (3, 4) is parallel to y = 2x + 1?', 'answer' => 'y = 2x − 2.'],
    ]"
>
    <x-calc.field name="eq" label="Given line" value="y = 2x + 1" type="text" inputmode="text" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="px" label="Point x" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="py" label="Point y" value="4" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Parallel line" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq' => 'y = 2x + 1', 'px' => '3', 'py' => '4'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'given' => ['label' => 'Given line'],
            'slopeIntercept' => ['label' => 'New line'],
            'standard' => ['label' => 'Standard form'],
            'pointSlope' => ['label' => 'Point-slope form'],
            'slope' => ['label' => 'Slope'],
            'gap' => ['label' => 'Distance between'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m∥ = m</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
