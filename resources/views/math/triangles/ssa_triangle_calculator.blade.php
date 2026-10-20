<x-calc.page
    title="SSA Triangle Calculator - SolveKit"
    description="Free SSA triangle calculator: the ambiguous case, with both possible triangles, one, or none."
    lede="Solve the ambiguous SSA case."
    about="Two sides and an angle opposite one of them may fit no triangle, one triangle or two: sin B = b sin A ÷ a can give an acute angle B and its obtuse supplement. With a = 6, b = 8 and A = 35° both fit, giving c = 10.42 or 2.69."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'angA'], 'want' => 'missing']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'Solve a = 6, b = 8, A = 35°.', 'answer' => 'Two triangles: c = 10.419047 cm or 2.687386 cm.'],
        ['question' => 'What if a = 3?', 'answer' => 'Then b sin A ≈ 4.59 is longer than a, so no triangle exists.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['ssa' => 'Two sides and an angle opposite one (SSA)']" selected="ssa" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:ssa">
            <x-calc.field name="a" label="Side a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:ssa">
            <x-calc.field name="b" label="Side b" value="8" min="0" step="any" />
        </div>
        <div data-show-when="given:ssa">
            <x-calc.field name="angA" label="Angle A (°)" value="35" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Missing sides and angles" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'ssa', 'unit' => 'cm', 'a' => 6, 'b' => 8, 'c' => 7, 'angA' => 35, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
        'One' => ['given' => 'ssa', 'unit' => 'cm', 'a' => 9, 'b' => 8, 'c' => 7, 'angA' => 35, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
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
            <li>sin B = b sin A ÷ a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
