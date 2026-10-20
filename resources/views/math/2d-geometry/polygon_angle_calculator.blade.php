<x-calc.page
    title="Polygon Angle Calculator - SolveKit"
    description="Free polygon angle calculator: interior, exterior and central angles and the angle sum of a regular polygon."
    lede="Find the angles of a polygon."
    about="Any polygon with n sides has interior angles adding to (n − 2) × 180°. In a regular polygon each interior angle is 180° − 360°/n and each exterior angle 360°/n: a pentagon has 108° and 72°."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['n', 'given', 'unit', 'a', 'circr', 'inr', 'perim', 'area'], 'shape' => 'polygon', 'want' => 'interior']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is each interior angle of a regular pentagon?', 'answer' => '108 °.'],
    ]"
>
    <x-calc.field name="n" label="Number of sides n" value="5" min="3" max="1000" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Side a', 'circr' => 'Circumradius R', 'inr' => 'Apothem (inradius) r', 'perim' => 'Perimeter P', 'area' => 'Area A']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Side a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:circr" hidden>
            <x-calc.field name="circr" label="Circumradius R" value="4.25325" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:inr" hidden>
            <x-calc.field name="inr" label="Apothem (inradius) r" value="3.44095" min="0" step="any" />
        </div>
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="25" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="43.0119" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Interior angle" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 5, 'given' => 'a', 'unit' => 'cm', 'a' => 5, 'circr' => 4.25325, 'inr' => 3.44095, 'perim' => 25, 'area' => 43.0119],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Side a'],
            'circr' => ['label' => 'Circumradius R'],
            'inr' => ['label' => 'Apothem (inradius) r'],
            'perim' => ['label' => 'Perimeter P'],
            'area' => ['label' => 'Area A'],
            'interior' => ['label' => 'Interior angle'],
            'exterior' => ['label' => 'Exterior angle'],
            'sum' => ['label' => 'Sum of interior angles'],
            'diagonals' => ['label' => 'Number of diagonals'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Interior = (n − 2) × 180° ÷ n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
