<x-calc.page
    title="Scalene Triangle Calculator - SolveKit"
    description="Free scalene triangle calculator: check whether a triangle is scalene and solve all its sides, angles, area and heights."
    lede="Check and solve a scalene triangle."
    about="A scalene triangle has three different sides and three different angles. Heron's formula gives its area from the sides alone."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'angA', 'angB', 'angC', 'x1', 'y1', 'x2', 'y2', 'x3', 'y3'], 'want' => 'type']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'What are the angles of the scalene triangle 5, 6, 7?', 'answer' => 'A = 44.4153086°, B = 57.12165044°, C = 78.46304097°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['sss' => 'Three sides (SSS)', 'sas' => 'Two sides and the angle between them (SAS)', 'asa' => 'Two angles and the side between them (ASA)', 'aas' => 'Two angles and another side (AAS)', 'ssa' => 'Two sides and an angle opposite one (SSA)', 'coords' => 'The coordinates of the vertices']" selected="sss" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sss,asa,aas,ssa">
            <x-calc.field name="a" label="Side a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas,ssa">
            <x-calc.field name="b" label="Side b" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas">
            <x-calc.field name="c" label="Side c" value="7" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sas,aas,ssa" hidden>
            <x-calc.field name="angA" label="Angle A (°)" value="44.4153" min="0" step="any" />
        </div>
        <div data-show-when="given:asa,aas" hidden>
            <x-calc.field name="angB" label="Angle B (°)" value="57.1217" min="0" step="any" />
        </div>
        <div data-show-when="given:asa" hidden>
            <x-calc.field name="angC" label="Angle C (°)" value="78.463" min="0" step="any" />
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

    <x-calc.result label="Classification" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'sss', 'unit' => 'cm', 'a' => 5, 'b' => 6, 'c' => 7, 'angA' => 44.4153, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
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
            <li>Heron: A = √(s(s − a)(s − b)(s − c))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
