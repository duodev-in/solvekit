<x-calc.page
    title="Law of Sines Calculator - SolveKit"
    description="Free law of sines calculator: solve a triangle from ASA, AAS or SSA, with both triangles in the ambiguous case."
    lede="Use the law of sines."
    about="a/sin A = b/sin B = c/sin C. With two angles and a side (ASA, AAS) there is one triangle; with two sides and a non-included angle (SSA) there may be two, one or none, the ambiguous case. Also known as sine triangle calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'angA', 'angB', 'angC'], 'want' => 'missing']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'Solve A = 40°, B = 60°, a = 10.', 'answer' => 'b = 13.472964 cm, c = 15.320889 cm, C = 80°.'],
        ['question' => 'What if a = 6, b = 8, A = 35°?', 'answer' => 'Two triangles: c = 10.419047 cm or 2.687386 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['asa' => 'Two angles and the side between them (ASA)', 'aas' => 'Two angles and another side (AAS)', 'ssa' => 'Two sides and an angle opposite one (SSA)']" selected="aas" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:asa,aas,ssa">
            <x-calc.field name="a" label="Side a" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:ssa" hidden>
            <x-calc.field name="b" label="Side b" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:aas,ssa">
            <x-calc.field name="angA" label="Angle A (°)" value="40" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:asa,aas">
            <x-calc.field name="angB" label="Angle B (°)" value="60" min="0" step="any" />
        </div>
        <div data-show-when="given:asa" hidden>
            <x-calc.field name="angC" label="Angle C (°)" value="78.463" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Missing sides and angles" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'aas', 'unit' => 'cm', 'a' => 10, 'b' => 6, 'c' => 7, 'angA' => 40, 'angB' => 60, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
        'Ambiguous' => ['given' => 'ssa', 'unit' => 'cm', 'a' => 6, 'b' => 8, 'c' => 7, 'angA' => 35, 'angB' => 60, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
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
            <li>a ÷ sin A = b ÷ sin B = c ÷ sin C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
