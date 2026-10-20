<x-calc.page
    title="Ellipse Calculator - SolveKit"
    description="Free ellipse calculator: area, exact perimeter, foci, eccentricity and axes from any two measures of an ellipse."
    lede="Solve an ellipse."
    about="An ellipse with semi-axes a and b has area πab and foci at distance c = √(a² − b²) from the centre. Its perimeter has no elementary formula; it is computed here exactly as 4a E(e) with the complete elliptic integral (Ramanujan's approximation is close but not exact)."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'ecc', 'area'], 'shape' => 'ellipse', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What are the area and perimeter of an ellipse with a = 5 and b = 3?', 'answer' => '47.1238898 cm² and 25.52699886 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a_b' => 'Semi-major axis a and semi-minor axis b', 'a_c' => 'Semi-major axis a and focal distance c', 'a_ecc' => 'Semi-major axis a and eccentricity e', 'a_area' => 'Semi-major axis a and area A', 'b_c' => 'Semi-minor axis b and focal distance c']" selected="a_b" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b,a_c,a_ecc,a_area" hidden>
            <x-calc.field name="a" label="Semi-major axis a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b,b_c" hidden>
            <x-calc.field name="b" label="Semi-minor axis b" value="3" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_c,b_c" hidden>
            <x-calc.field name="c" label="Focal distance c" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:a_ecc" hidden>
            <x-calc.field name="ecc" label="Eccentricity e" value="0.8" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="47.1239" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a_b', 'unit' => 'cm', 'a' => 5, 'b' => 3, 'c' => 4, 'ecc' => 0.8, 'area' => 47.1239],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Semi-major axis a'],
            'b' => ['label' => 'Semi-minor axis b'],
            'c' => ['label' => 'Focal distance c'],
            'ecc' => ['label' => 'Eccentricity e'],
            'area' => ['label' => 'Area A'],
            'perim' => ['label' => 'Perimeter (circumference)'],
            'latus' => ['label' => 'Semi-latus rectum'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = πab</li>
            <li>P = 4a E(e)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
