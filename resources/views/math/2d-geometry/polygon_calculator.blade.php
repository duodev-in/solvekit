<x-calc.page
    title="Polygon Calculator - SolveKit"
    description="Free regular polygon calculator: side, circumradius, apothem, perimeter, area and angles of a regular polygon with any number of sides."
    lede="Solve a regular polygon."
    about="A regular polygon has n equal sides and equal angles. From any one length (side, circumradius R, apothem r, perimeter or area) everything follows: A = na²/(4 tan(π/n)), interior angle 180° − 360°/n. Also known as regular polygon calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['n', 'given', 'unit', 'a', 'circr', 'inr', 'perim', 'area'], 'shape' => 'polygon', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a regular hexagon with side 4?', 'answer' => '41.56921938 cm².'],
    ]"
>
    <x-calc.field name="n" label="Number of sides n" value="6" min="3" max="1000" step="1" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Side a', 'circr' => 'Circumradius R', 'inr' => 'Apothem (inradius) r', 'perim' => 'Perimeter P', 'area' => 'Area A']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Side a" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:circr" hidden>
            <x-calc.field name="circr" label="Circumradius R" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:inr" hidden>
            <x-calc.field name="inr" label="Apothem (inradius) r" value="3.4641" min="0" step="any" />
        </div>
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="24" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="41.5692" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => 6, 'given' => 'a', 'unit' => 'cm', 'a' => 4, 'circr' => 4, 'inr' => 3.4641, 'perim' => 24, 'area' => 41.5692],
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
            <li>A = n a² ÷ (4 tan(π/n))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
