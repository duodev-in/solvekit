<x-calc.page
    title="Area of a Regular Polygon Calculator - SolveKit"
    description="Free area of a regular polygon calculator: A = ½ × perimeter × apothem for any number of sides."
    lede="Find the area of a regular polygon."
    about="Split a regular polygon into n triangles from the centre: each has base a and height r (the apothem), so A = ½·n·a·r = ½·P·r = na²/(4 tan(π/n))."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['n', 'given', 'unit', 'a', 'circr', 'inr', 'perim', 'area'], 'shape' => 'polygon', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a regular octagon with side 3?', 'answer' => '43.45584412 cm².'],
    ]"
>
    <x-calc.field name="n" label="Number of sides n" value="8" min="3" max="1000" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Side a', 'circr' => 'Circumradius R', 'inr' => 'Apothem (inradius) r', 'perim' => 'Perimeter P', 'area' => 'Area A']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Side a" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:circr" hidden>
            <x-calc.field name="circr" label="Circumradius R" value="3.91969" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:inr" hidden>
            <x-calc.field name="inr" label="Apothem (inradius) r" value="3.62132" min="0" step="any" />
        </div>
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="24" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="43.4558" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 8, 'given' => 'a', 'unit' => 'cm', 'a' => 3, 'circr' => 3.91969, 'inr' => 3.62132, 'perim' => 24, 'area' => 43.4558],
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
            <li>A = ½ P r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
