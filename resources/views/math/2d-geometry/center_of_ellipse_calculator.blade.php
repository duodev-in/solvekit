<x-calc.page
    title="Center of Ellipse Calculator - SolveKit"
    description="Free center of an ellipse calculator: find the centre, axes and foci from the general equation by completing the square."
    lede="Find the centre of an ellipse."
    about="Group the x and y terms and complete the square: 9x² + 25y² − 18x + 100y − 116 = 0 becomes 9(x − 1)² + 25(y + 2)² = 225, so the centre is (1, −2). Rotated ellipses (with an xy term) are handled too."
    :calc="['engine' => 'mt-shape', 'tool' => 'conic', 'fields' => ['eq'], 'want' => 'center']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the centre of 9x² + 25y² − 18x + 100y − 116 = 0?', 'answer' => '(1, −2).'],
    ]"
>
    <x-calc.field name="eq" label="Equation of the ellipse" value="9x^2 + 25y^2 - 18x + 100y - 116 = 0" type="text" inputmode="text" />

    <x-calc.result label="Centre" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq' => '9x^2 + 25y^2 - 18x + 100y - 116 = 0'],
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
            <li>complete the square</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
