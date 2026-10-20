<x-calc.page
    title="Corner Point Calculator - SolveKit"
    description="Free corner point calculator: the vertices of the feasible region of linear inequalities and the maximum or minimum of a linear objective."
    lede="Find corner points of a feasible region."
    about="In linear programming the feasible region of linear inequalities is a polygon, and a linear objective reaches its maximum or minimum at a corner (vertex). The calculator intersects every pair of boundary lines, keeps the feasible points and evaluates the objective exactly. Also known as linear programming calculator."
    :calc="['engine' => 'mt-matrix', 'tool' => 'corner', 'fields' => ['constraints', 'objective', 'goal', 'nonneg']]"
    :how-to="[
        ['name' => 'Type the constraints', 'text' => 'One inequality per line in x and y.'],
        ['name' => 'Read the corners', 'text' => 'The best corner for the objective is given first.'],
    ]"
    :faqs="[
        ['question' => 'Maximise 3x + 2y subject to x + y ≤ 4, x + 3y ≤ 6, x, y ≥ 0.', 'answer' => 'Maximum 12 at (4, 0).'],
    ]"
>
    <x-calc.textarea name="constraints" label="Constraints (one per line)" value="x + y <= 4
x + 3y <= 6" rows="4" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="objective" label="Objective (optional)" value="3x + 2y" type="text" inputmode="text" />
        <x-calc.select name="goal" label="Goal" :options="['max' => 'Maximise', 'min' => 'Minimise']" selected="max" />
    </div>

    <x-calc.select name="nonneg" label="Also require" :options="['yes' => 'x ≥ 0 and y ≥ 0', 'no' => 'Nothing else']" selected="yes" />

    <x-calc.result label="Corner points" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['constraints' => 'x + y <= 4
x + 3y <= 6', 'objective' => '3x + 2y', 'goal' => 'max', 'nonneg' => 'yes'],
        'Minimise' => ['constraints' => 'x + y >= 3
2x + y >= 4
x <= 5
y <= 5', 'objective' => '2x + 3y', 'goal' => 'min', 'nonneg' => 'yes'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Feasible region" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'corners' => ['label' => 'Corner points'],
            'constraints' => ['label' => 'Constraints'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>optimum at a vertex</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
