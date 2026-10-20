<x-calc.page
    title="Heron's Formula Calculator - SolveKit"
    description="Free Heron's formula calculator: the area of a triangle from its three sides, A = √(s(s − a)(s − b)(s − c))."
    lede="Find the area from three sides."
    about="Heron's formula needs only the sides: with the semi-perimeter s = (a + b + c)/2, the area is √(s(s − a)(s − b)(s − c)). For 5, 6, 7: s = 9 and A = √216 = 14.70. Also known as 3 sides triangle area calculator and scalene triangle area calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'a', 'b', 'c'], 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a triangle with sides 5, 6 and 7?', 'answer' => '14.69693846 cm².'],
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

    <x-calc.result label="Area" />

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
            <li>A = √(s(s − a)(s − b)(s − c))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
