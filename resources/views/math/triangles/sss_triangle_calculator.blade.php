<x-calc.page
    title="SSS Triangle Calculator - SolveKit"
    description="Free SSS triangle calculator: all three angles, area, heights and centres from the three sides."
    lede="Solve a triangle from three sides."
    about="Three sides fix a triangle as long as each is shorter than the other two together. The law of cosines gives each angle: A = acos((b² + c² − a²) ÷ 2bc). Sides 5, 6, 7 give angles 44.42°, 57.12° and 78.46°."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'c'], 'want' => 'missing']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'Solve the triangle with sides 5, 6 and 7.', 'answer' => 'A = 44.415309°, B = 57.12165°, C = 78.463041°.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['sss' => 'Three sides (SSS)']" selected="sss" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:sss">
            <x-calc.field name="a" label="Side a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:sss">
            <x-calc.field name="b" label="Side b" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:sss">
            <x-calc.field name="c" label="Side c" value="7" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Missing sides and angles" />

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
            <li>A = acos((b² + c² − a²) ÷ 2bc)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
