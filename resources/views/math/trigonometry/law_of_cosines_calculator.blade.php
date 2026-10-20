<x-calc.page
    title="Law of Cosines Calculator - SolveKit"
    description="Free law of cosines calculator: a missing side from two sides and the included angle, or all angles from three sides."
    lede="Use the law of cosines."
    about="c² = a² + b² − 2ab cos C generalises Pythagoras to any triangle. Use it with two sides and the angle between them (SAS) to find the third side, or with three sides (SSS) to find the angles. Also known as cosine triangle calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'angA'], 'want' => 'missing']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'Find a when b = 5, c = 8 and A = 60°.', 'answer' => 'a = 7 cm, B = 38.213211°, C = 81.786789°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['sss' => 'Three sides (SSS)', 'sas' => 'Two sides and the angle between them (SAS)']" selected="sas" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sss" hidden>
            <x-calc.field name="a" label="Side a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas">
            <x-calc.field name="b" label="Side b" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sss,sas">
            <x-calc.field name="c" label="Side c" value="8" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sas">
            <x-calc.field name="angA" label="Angle A (°)" value="60" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Missing sides and angles" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'sas', 'unit' => 'cm', 'a' => 5, 'b' => 5, 'c' => 8, 'angA' => 60, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
        'SSS' => ['given' => 'sss', 'unit' => 'cm', 'a' => 5, 'b' => 5, 'c' => 8, 'angA' => 60, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
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
