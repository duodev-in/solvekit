<x-calc.page
    title="Intersection of Two Lines Calculator - SolveKit"
    description="Free intersection of two lines calculator: the crossing point (exact), or whether the lines are parallel or the same."
    lede="Find where two lines meet."
    about="Solve the two equations together. y = 2x + 1 and x + y = 7 meet at (2, 5). Lines with the same slope are parallel (no intersection) or identical (infinitely many)."
    :calc="['engine' => 'mt-coord', 'tool' => 'intersection', 'fields' => ['eq1', 'eq2']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Where do y = 2x + 1 and x + y = 7 meet?', 'answer' => '(2, 5).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="eq1" label="Line 1" value="y = 2x + 1" type="text" inputmode="text" />
        <x-calc.field name="eq2" label="Line 2" value="x + y = 7" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Intersection point" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq1' => 'y = 2x + 1', 'eq2' => 'x + y = 7'],
        'Parallel' => ['eq1' => 'y = 2x + 1', 'eq2' => '4x - 2y = 6'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'point' => ['label' => 'Point'],
            'lines' => ['label' => 'Lines'],
            'angle' => ['label' => 'Angle between them'],
            'relation' => ['label' => 'Relation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Cramer's rule</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
