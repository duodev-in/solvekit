<x-calc.page
    title="Foci of an Ellipse Calculator - SolveKit"
    description="Free foci of an ellipse calculator: the two foci at distance c = √(a² − b²) from the centre, with the eccentricity."
    lede="Find the foci of an ellipse."
    about="The foci lie on the major axis at distance c = √(a² − b²) from the centre. Every point of the ellipse has the same total distance 2a to the two foci, which is how gardeners draw ellipses with a loop of string."
    :calc="['engine' => 'mt-shape', 'tool' => 'ellipse_eq', 'fields' => ['h', 'k', 'a', 'b'], 'want' => 'foci']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Where are the foci of the ellipse with centre (1, −2) and semi-axes 5 and 3?', 'answer' => '(−3, −2) and (5, −2).'],
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

    <x-calc.result label="Foci" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['h' => 1, 'k' => -2, 'a' => 5, 'b' => 3],
        'Vertical' => ['h' => 0, 'k' => 0, 'a' => 2, 'b' => 4],
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
            <li>c = √(a² − b²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
