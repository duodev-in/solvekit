<x-calc.page
    title="Linear Interpolation Calculator - SolveKit"
    description="Free linear interpolation calculator: y at any x on the straight line through two known points (or extrapolate)."
    lede="Interpolate between two points."
    about="Linear interpolation assumes a straight line between known points: y = y₁ + (x − x₁)(y₂ − y₁) ÷ (x₂ − x₁). Between (2, 4) and (6, 10), x = 5 gives y = 8.5. Also known as lerp calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'interpolate', 'fields' => ['x1', 'y1', 'x2', 'y2', 'x']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is y at x = 5 between (2, 4) and (6, 10)?', 'answer' => '17/2 = 8.5.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="x₁" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="y₁" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="x₂" value="6" type="text" inputmode="decimal" />
        <x-calc.field name="y2" label="y₂" value="10" type="text" inputmode="decimal" />
    </div>

    <x-calc.field name="x" label="Find y at x =" value="5" type="text" inputmode="decimal" />

    <x-calc.result label="Interpolated y" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '2', 'y1' => '4', 'x2' => '6', 'y2' => '10', 'x' => '5'],
        'Extrapolate' => ['x1' => '2', 'y1' => '4', 'x2' => '6', 'y2' => '10', 'x' => '8'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'slope' => ['label' => 'Slope'],
            'fraction' => ['label' => 'Position'],
            'line' => ['label' => 'Line'],
            'kind' => ['label' => 'Type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>y = y₁ + (x − x₁)(y₂ − y₁) ÷ (x₂ − x₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
