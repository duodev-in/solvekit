<x-calc.page
    title="Latus Rectum Calculator - SolveKit"
    description="Free latus rectum calculator: the length and endpoints of the latus rectum of a parabola, ellipse or hyperbola from its equation."
    lede="Find the latus rectum."
    about="The latus rectum is the chord through a focus perpendicular to the axis. For y² = 4px it is |4p|; for an ellipse or hyperbola with semi-axes a and b it is 2b²/a. y² = 12x has a latus rectum of 12, from (3, −6) to (3, 6)."
    :calc="['engine' => 'mt-shape', 'tool' => 'conic', 'fields' => ['eq'], 'want' => 'latus']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the latus rectum of y² = 12x?', 'answer' => '12.'],
        ['question' => 'And of x²/25 + y²/9 = 1?', 'answer' => '3.6.'],
    ]"
>
    <x-calc.field name="eq" label="Equation of the conic" value="y^2 = 12x" type="text" inputmode="text" />

    <x-calc.result label="Latus rectum length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq' => 'y^2 = 12x'],
        'Ellipse' => ['eq' => 'x^2/25 + y^2/9 = 1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'latus' => ['label' => 'Latus rectum'],
            'standard' => ['label' => 'Standard form'],
            'foci' => ['label' => 'Foci'],
            'axes' => ['label' => 'Axes'],
            'ecc' => ['label' => 'Eccentricity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|4p|</li>
            <li>2b² ÷ a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
