<x-calc.page
    title="Gradient Calculator - SolveKit"
    description="Free gradient calculator: the gradient (slope) between two points as a percentage grade, ratio and angle."
    lede="Find a gradient."
    about="The gradient of a line is its slope; as a grade it is rise ÷ run × 100%. A road climbing 8 m over 100 m has an 8% gradient, 4.57°."
    :calc="['engine' => 'mt-coord', 'tool' => 'slope', 'fields' => ['x1', 'y1', 'x2', 'y2'], 'want' => 'grade']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the gradient from (0, 0) to (100, 8)?', 'answer' => '8%.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="x₁" value="0" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="y₁" value="0" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="x₂" value="100" type="text" inputmode="decimal" />
        <x-calc.field name="y2" label="y₂" value="8" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Gradient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '0', 'y1' => '0', 'x2' => '100', 'y2' => '8'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'slope' => ['label' => 'Slope'],
            'angle' => ['label' => 'Angle'],
            'grade' => ['label' => 'Grade'],
            'ratio' => ['label' => 'Rise : run'],
            'equation' => ['label' => 'Line'],
            'length' => ['label' => 'Distance along the slope'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>grade = Δy ÷ Δx × 100%</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
