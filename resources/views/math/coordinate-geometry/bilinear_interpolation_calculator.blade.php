<x-calc.page
    title="Bilinear Interpolation Calculator - SolveKit"
    description="Free bilinear interpolation calculator: estimate a value inside a grid cell from its four corner values."
    lede="Interpolate on a 2D grid."
    about="Bilinear interpolation interpolates along x on the two edges of a cell, then along y between those results. It is used for image scaling and for reading tables with two inputs."
    :calc="['engine' => 'mt-coord', 'tool' => 'interpolate', 'fields' => ['x1', 'x2', 'y1', 'y2', 'q11', 'q21', 'q12', 'q22', 'x', 'y'], 'kind' => 'bilinear']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the value at the centre of a cell with corners 1, 2, 3 and 4?', 'answer' => '2.5.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="x₁" value="0" step="any" />
        <x-calc.field name="x2" label="x₂" value="1" step="any" />
        <x-calc.field name="y1" label="y₁" value="0" step="any" />
        <x-calc.field name="y2" label="y₂" value="1" step="any" />
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="q11" label="Q₁₁ at (x₁, y₁)" value="1" step="any" />
        <x-calc.field name="q21" label="Q₂₁ at (x₂, y₁)" value="2" step="any" />
        <x-calc.field name="q12" label="Q₁₂ at (x₁, y₂)" value="3" step="any" />
        <x-calc.field name="q22" label="Q₂₂ at (x₂, y₂)" value="4" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x" label="x" value="0.5" step="any" />
        <x-calc.field name="y" label="y" value="0.5" step="any" />
    </div>

    <x-calc.result label="Interpolated value" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => 0, 'x2' => 1, 'y1' => 0, 'y2' => 1, 'q11' => 1, 'q21' => 2, 'q12' => 3, 'q22' => 4, 'x' => 0.5, 'y' => 0.5],
        'Table' => ['x1' => 20, 'x2' => 30, 'y1' => 100, 'y2' => 200, 'q11' => 0.5, 'q21' => 0.7, 'q12' => 0.9, 'q22' => 1.2, 'x' => 24, 'y' => 150],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r1' => ['label' => 'R₁ (along x at y₁)'],
            'r2' => ['label' => 'R₂ (along x at y₂)'],
            'weights' => ['label' => 'Corner weights'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = weighted average of the corners</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
