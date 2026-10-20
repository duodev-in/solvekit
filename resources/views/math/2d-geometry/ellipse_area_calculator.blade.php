<x-calc.page
    title="Ellipse Area Calculator - SolveKit"
    description="Free ellipse area calculator: A = πab from the semi-axes (or from a and the eccentricity)."
    lede="Find the area of an ellipse."
    about="The area of an ellipse is π times the product of its semi-axes, A = πab: a circle is the case a = b. Use full axis lengths? Halve them first."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'ecc', 'area'], 'shape' => 'ellipse', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of an ellipse with semi-axes 5 and 3?', 'answer' => '47.1238898 cm².'],
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
        </ul>
    </x-slot:formula>
</x-calc.page>
