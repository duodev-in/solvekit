<x-calc.page
    title="Equation of a Circle Calculator - SolveKit"
    description="Free equation of a circle calculator: standard and general form from the centre and radius, a diameter, three points or an equation."
    lede="Find the equation of a circle."
    about="A circle with centre (h, k) and radius r is (x − h)² + (y − k)² = r². Expanding gives the general form x² + y² + Dx + Ey + F = 0. The circle can also be found from a diameter's endpoints, from three points, or from a general equation by completing the square. Also known as standard equation of a circle calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'circle_eq', 'fields' => ['given', 'h', 'k', 'r', 'x1', 'y1', 'x2', 'y2', 'x3', 'y3', 'eq'], 'want' => 'standard']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the equation of the circle with centre (2, −3) and radius 4?', 'answer' => '(x − 2)² + (y + 3)² = 16.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['center' => 'The centre and radius', 'diameter' => 'The endpoints of a diameter', 'points' => 'Three points on the circle', 'general' => 'The general equation']" selected="center" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:center">
            <x-calc.field name="h" label="Centre h" value="2" step="any" />
        </div>
        <div data-show-when="given:center">
            <x-calc.field name="k" label="Centre k" value="-3" step="any" />
        </div>
        <div data-show-when="given:center">
            <x-calc.field name="r" label="Radius r" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:diameter,points" hidden>
            <x-calc.field name="x1" label="x₁" value="-2" step="any" />
        </div>
        <div data-show-when="given:diameter,points" hidden>
            <x-calc.field name="y1" label="y₁" value="1" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:diameter,points" hidden>
            <x-calc.field name="x2" label="x₂" value="4" step="any" />
        </div>
        <div data-show-when="given:diameter,points" hidden>
            <x-calc.field name="y2" label="y₂" value="9" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points" hidden>
            <x-calc.field name="x3" label="x₃" value="6" step="any" />
        </div>
        <div data-show-when="given:points" hidden>
            <x-calc.field name="y3" label="y₃" value="5" step="any" />
        </div>
    </div>

    <div data-show-when="given:general" hidden>
        <x-calc.field name="eq" label="Equation" value="x^2 + y^2 - 4x + 6y - 3 = 0" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Standard form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'center', 'h' => 2, 'k' => -3, 'r' => 4, 'x1' => -2, 'y1' => 1, 'x2' => 4, 'y2' => 9, 'x3' => 6, 'y3' => 5, 'eq' => 'x^2 + y^2 - 4x + 6y - 3 = 0'],
        'Three points' => ['given' => 'points', 'h' => 2, 'k' => -3, 'r' => 4, 'x1' => -2, 'y1' => 1, 'x2' => 4, 'y2' => 9, 'x3' => 6, 'y3' => 5, 'eq' => 'x^2 + y^2 - 4x + 6y - 3 = 0'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'standard' => ['label' => 'Standard form'],
            'general' => ['label' => 'General form'],
            'center' => ['label' => 'Centre'],
            'radius' => ['label' => 'Radius'],
            'diameter' => ['label' => 'Diameter'],
            'area' => ['label' => 'Area'],
            'circ' => ['label' => 'Circumference'],
            'param' => ['label' => 'Parametric form'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(x − h)² + (y − k)² = r²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
