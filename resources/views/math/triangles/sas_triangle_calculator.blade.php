<x-calc.page
    title="SAS Triangle Calculator - SolveKit"
    description="Free SAS triangle calculator: the third side and both remaining angles from two sides and the included angle."
    lede="Solve a triangle from SAS."
    about="With two sides and the angle between them, the law of cosines gives the third side, a² = b² + c² − 2bc cos A, and then the other angles follow. SAS always fixes exactly one triangle."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'b', 'c', 'angA'], 'want' => 'missing']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'Solve b = 5, c = 8, A = 60°.', 'answer' => 'a = 7 cm, B = 38.213211°, C = 81.786789°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['sas' => 'Two sides and the angle between them (SAS)']" selected="sas" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sas">
            <x-calc.field name="b" label="Side b" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sas">
            <x-calc.field name="c" label="Side c" value="8" min="0" step="any" />
        </div>
        <div data-show-when="given:sas">
            <x-calc.field name="angA" label="Angle A (°)" value="60" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Missing sides and angles" />

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
            <li>a² = b² + c² − 2bc cos A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
