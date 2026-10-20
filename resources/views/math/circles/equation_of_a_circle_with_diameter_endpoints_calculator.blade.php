<x-calc.page
    title="Equation of a Circle with Diameter Endpoints Calculator - SolveKit"
    description="Free calculator for the equation of a circle from the endpoints of a diameter."
    lede="Find a circle from a diameter."
    about="The centre is the midpoint of the diameter and the radius is half its length. Endpoints (−2, 1) and (4, 9) give centre (1, 5), radius 5 and (x − 1)² + (y − 5)² = 25."
    :calc="['engine' => 'mt-tri', 'tool' => 'circle_eq', 'fields' => ['given', 'h', 'k', 'r', 'x1', 'y1', 'x2', 'y2', 'x3', 'y3', 'eq'], 'want' => 'standard']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What circle has a diameter from (−2, 1) to (4, 9)?', 'answer' => '(x − 1)² + (y − 5)² = 25.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['center' => 'The centre and radius', 'diameter' => 'The endpoints of a diameter', 'points' => 'Three points on the circle', 'general' => 'The general equation']" selected="diameter" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:center" hidden>
            <x-calc.field name="h" label="Centre h" value="2" step="any" />
        </div>
        <div data-show-when="given:center" hidden>
            <x-calc.field name="k" label="Centre k" value="-3" step="any" />
        </div>
        <div data-show-when="given:center" hidden>
            <x-calc.field name="r" label="Radius r" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:diameter,points">
            <x-calc.field name="x1" label="x₁" value="-2" step="any" />
        </div>
        <div data-show-when="given:diameter,points">
            <x-calc.field name="y1" label="y₁" value="1" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:diameter,points">
            <x-calc.field name="x2" label="x₂" value="4" step="any" />
        </div>
        <div data-show-when="given:diameter,points">
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
        'Example' => ['given' => 'diameter', 'h' => 2, 'k' => -3, 'r' => 4, 'x1' => -2, 'y1' => 1, 'x2' => 4, 'y2' => 9, 'x3' => 6, 'y3' => 5, 'eq' => 'x^2 + y^2 - 4x + 6y - 3 = 0'],
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
