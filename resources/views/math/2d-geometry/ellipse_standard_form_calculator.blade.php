<x-calc.page
    title="Ellipse Standard Form Calculator - SolveKit"
    description="Free ellipse standard form calculator: the equation (x − h)²/a² + (y − k)²/b² = 1 from the centre and semi-axes, with the general form and foci."
    lede="Write an ellipse in standard form."
    about="The standard form (x − h)²/a² + (y − k)²/b² = 1 shows the centre (h, k) and the semi-axes directly. Expanding gives the general form Ax² + Cy² + Dx + Ey + F = 0. To go the other way, use the Conic Sections Calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'ellipse_eq', 'fields' => ['h', 'k', 'a', 'b'], 'want' => 'standard']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Write the ellipse with centre (1, −2) and semi-axes 5 and 3.', 'answer' => '(x − 1)²/25 + (y + 2)²/9 = 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="h" label="Centre h (x)" value="1" step="any" />
        <x-calc.field name="k" label="Centre k (y)" value="-2" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="a" label="Horizontal semi-axis" value="5" min="0" step="any" />
        <x-calc.field name="b" label="Vertical semi-axis" value="3" min="0" step="any" />
    </div>

    <x-calc.result label="Standard form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['h' => 1, 'k' => -2, 'a' => 5, 'b' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'standard' => ['label' => 'Standard form'],
            'general' => ['label' => 'General form'],
            'center' => ['label' => 'Centre'],
            'foci' => ['label' => 'Foci'],
            'vertices' => ['label' => 'Vertices'],
            'ecc' => ['label' => 'Eccentricity'],
            'c' => ['label' => 'Focal distance c'],
            'extra' => ['label' => 'Area and perimeter'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(x − h)²/a² + (y − k)²/b² = 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
