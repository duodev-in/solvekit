<x-calc.page
    title="Triangle Area Calculator - SolveKit"
    description="Free triangle area calculator: from base and height, three sides (Heron), two sides and an angle, two angles and a side, or vertex coordinates."
    lede="Find the area of any triangle."
    about="The basic formula is half the base times the height. Without a height, use Heron's formula (three sides), ½ab sin C (two sides and the included angle), the law of sines (two angles and a side) or the shoelace formula (coordinates). Also known as area of an obtuse triangle calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'angA', 'angB', 'angC', 'hb', 'x1', 'y1', 'x2', 'y2', 'x3', 'y3'], 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a triangle with base 6 and height 4.899?', 'answer' => '14.697 cm².'],
        ['question' => 'And with sides 5, 6 and 7?', 'answer' => '14.69693846 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['bh' => 'Base and height', 'sss' => 'Three sides (SSS)', 'sas' => 'Two sides and the angle between them (SAS)', 'asa' => 'Two angles and the side between them (ASA)', 'aas' => 'Two angles and another side (AAS)', 'coords' => 'The coordinates of the vertices']" selected="bh" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sss,asa,aas" hidden>
            <x-calc.field name="a" label="Side a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas,bh">
            <x-calc.field name="b" label="Side b" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas" hidden>
            <x-calc.field name="c" label="Side c" value="7" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sas,aas" hidden>
            <x-calc.field name="angA" label="Angle A (°)" value="44.4153" min="0" step="any" />
        </div>
        <div data-show-when="given:asa,aas" hidden>
            <x-calc.field name="angB" label="Angle B (°)" value="57.1217" min="0" step="any" />
        </div>
        <div data-show-when="given:asa" hidden>
            <x-calc.field name="angC" label="Angle C (°)" value="78.463" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:bh">
            <x-calc.field name="hb" label="Height to side b" value="4.899" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:coords" hidden>
            <x-calc.field name="x1" label="A: x₁" value="0" step="any" />
        </div>
        <div data-show-when="given:coords" hidden>
            <x-calc.field name="y1" label="A: y₁" value="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:coords" hidden>
            <x-calc.field name="x2" label="B: x₂" value="4" step="any" />
        </div>
        <div data-show-when="given:coords" hidden>
            <x-calc.field name="y2" label="B: y₂" value="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:coords" hidden>
            <x-calc.field name="x3" label="C: x₃" value="1" step="any" />
        </div>
        <div data-show-when="given:coords" hidden>
            <x-calc.field name="y3" label="C: y₃" value="3" step="any" />
        </div>
    </div>

    <x-calc.result label="Area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'bh', 'unit' => 'cm', 'a' => 5, 'b' => 6, 'c' => 7, 'angA' => 44.4153, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
        'Sides' => ['given' => 'sss', 'unit' => 'cm', 'a' => 5, 'b' => 6, 'c' => 7, 'angA' => 44.4153, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'sides' => ['label' => 'Sides'],
            'angles' => ['label' => 'Angles'],
            'area' => ['label' => 'Area'],
            'perim' => ['label' => 'Perimeter'],
            'heights' => ['label' => 'Heights'],
            'medians' => ['label' => 'Medians'],
            'bisectors' => ['label' => 'Angle bisectors'],
            'midsegments' => ['label' => 'Midsegments'],
            'inr' => ['label' => 'Inradius'],
            'circr' => ['label' => 'Circumradius'],
            'type' => ['label' => 'Type'],
            'exterior' => ['label' => 'Exterior angles'],
            'centres' => ['label' => 'Centres'],
            'second' => ['label' => 'Ambiguous case'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = ½bh</li>
            <li>A = ½ab sin C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
