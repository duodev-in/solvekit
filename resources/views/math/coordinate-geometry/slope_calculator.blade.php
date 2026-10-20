<x-calc.page
    title="Slope Calculator - SolveKit"
    description="Free slope calculator: m = (y₂ − y₁) ÷ (x₂ − x₁) as an exact fraction, with the angle, grade and line equation."
    lede="Find the slope between two points."
    about="Slope measures steepness: rise over run. Between (1, 2) and (4, 8) it is 6 ÷ 3 = 2. Positive slopes go up to the right, zero is horizontal, and vertical lines have undefined slope. Also known as triangle slope calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'slope', 'fields' => ['x1', 'y1', 'x2', 'y2']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the slope through (1, 2) and (4, 8)?', 'answer' => '2.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="x₁" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="y₁" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="x₂" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="y2" label="y₂" value="8" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Slope m" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '1', 'y1' => '2', 'x2' => '4', 'y2' => '8'],
        'Fractions' => ['x1' => '-1/2', 'y1' => '3', 'x2' => '5/2', 'y2' => '1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'slope' => ['label' => 'Slope'],
            'angle' => ['label' => 'Angle'],
            'grade' => ['label' => 'Grade'],
            'ratio' => ['label' => 'Rise : run'],
            'equation' => ['label' => 'Line'],
            'length' => ['label' => 'Segment length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>m = (y₂ − y₁) ÷ (x₂ − x₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
