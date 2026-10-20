<x-calc.page
    title="Area of an Oblique Triangle Calculator - SolveKit"
    description="Free area of an oblique triangle calculator: ½ab sin C, Heron or the law of sines for triangles without a right angle."
    lede="Find the area of an oblique triangle."
    about="An oblique triangle has no right angle, so no side is a ready-made height. Use A = ½bc sin A with two sides and the angle between them, or Heron's formula with three sides."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'angA', 'angB', 'angC', 'x1', 'y1', 'x2', 'y2', 'x3', 'y3'], 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'What is the area with b = 5, c = 8 and A = 60°?', 'answer' => '17.32050808 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['sss' => 'Three sides (SSS)', 'sas' => 'Two sides and the angle between them (SAS)', 'asa' => 'Two angles and the side between them (ASA)', 'aas' => 'Two angles and another side (AAS)', 'ssa' => 'Two sides and an angle opposite one (SSA)', 'coords' => 'The coordinates of the vertices']" selected="sas" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sss,asa,aas,ssa" hidden>
            <x-calc.field name="a" label="Side a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas,ssa">
            <x-calc.field name="b" label="Side b" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas">
            <x-calc.field name="c" label="Side c" value="8" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sas,aas,ssa">
            <x-calc.field name="angA" label="Angle A (°)" value="60" min="0" step="any" />
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

    <x-calc.result label="Area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'sas', 'unit' => 'cm', 'a' => 5, 'b' => 5, 'c' => 8, 'angA' => 60, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
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
            <li>A = ½bc sin A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
