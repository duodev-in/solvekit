<x-calc.page
    title="Pentagon Calculator - SolveKit"
    description="Free pentagon calculator: side, area, perimeter, circumradius, apothem and angles of a regular pentagon from any one measure."
    lede="Solve a regular pentagon."
    about="A regular pentagon has 5 equal sides; each interior angle is 108° and the angles add up to 540°. Its area is 5a² ÷ (4 tan(36°)), and it has 5 diagonals."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'circr', 'inr', 'perim', 'area'], 'shape' => 'polygon', 'want' => 'area', 'n' => 5]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a regular pentagon with side 4?', 'answer' => '27.52763841 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Side a', 'circr' => 'Circumradius R', 'inr' => 'Apothem (inradius) r', 'perim' => 'Perimeter P', 'area' => 'Area A']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Side a" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:circr" hidden>
            <x-calc.field name="circr" label="Circumradius R" value="3.4026" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:inr" hidden>
            <x-calc.field name="inr" label="Apothem (inradius) r" value="2.75276" min="0" step="any" />
        </div>
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="20" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="27.5276" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a', 'unit' => 'cm', 'a' => 4, 'circr' => 3.4026, 'inr' => 2.75276, 'perim' => 20, 'area' => 27.5276],
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
            <li>A = 5a² ÷ (4 tan(π/5))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
