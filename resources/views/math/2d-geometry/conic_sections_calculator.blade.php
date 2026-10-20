<x-calc.page
    title="Conic Sections Calculator - SolveKit"
    description="Free conic sections calculator: identify a circle, ellipse, parabola or hyperbola from its equation and find the centre, foci, axes, eccentricity and graph."
    lede="Identify and analyse a conic."
    about="Every equation Ax² + Bxy + Cy² + Dx + Ey + F = 0 is a conic. The discriminant B² − 4AC decides the type: negative for an ellipse (or circle), zero for a parabola, positive for a hyperbola. An xy term means the axes are rotated; the calculator rotates them away and completes the square."
    :calc="['engine' => 'mt-shape', 'tool' => 'conic', 'fields' => ['eq']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What kind of conic is 4x² + 9y² = 36?', 'answer' => 'Ellipse: x²/9 + y²/4 = 1.'],
        ['question' => 'And x²/9 − y²/16 = 1?', 'answer' => 'Hyperbola with foci (5, 0) and (−5, 0).'],
    ]"
>
    <x-calc.field name="eq" label="Equation in x and y" value="4x^2 + 9y^2 = 36" type="text" inputmode="text" />

    <x-calc.result label="Conic section" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq' => '4x^2 + 9y^2 = 36'],
        'Hyperbola' => ['eq' => 'x^2/9 - y^2/16 = 1'],
        'Parabola' => ['eq' => 'y = x^2 - 4x + 1'],
        'Rotated' => ['eq' => 'x^2 + xy + y^2 = 3'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'general' => ['label' => 'General form'],
            'standard' => ['label' => 'Standard form'],
            'center' => ['label' => 'Centre or vertex'],
            'axes' => ['label' => 'Axes'],
            'foci' => ['label' => 'Foci'],
            'ecc' => ['label' => 'Eccentricity'],
            'vertices' => ['label' => 'Vertices'],
            'extra' => ['label' => 'More'],
            'rotation' => ['label' => 'Rotation'],
            'disc' => ['label' => 'Discriminant'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>B² − 4AC</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
