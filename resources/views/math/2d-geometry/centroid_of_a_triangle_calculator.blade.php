<x-calc.page
    title="Centroid of a Triangle Calculator - SolveKit"
    description="Free centroid of a triangle calculator: the average of the three vertices, where the medians meet."
    lede="Find the centroid of a triangle."
    about="The centroid G of a triangle is the average of its vertices, ((x₁ + x₂ + x₃)/3, (y₁ + y₂ + y₃)/3). The three medians meet there, and it divides each median 2 : 1 from the vertex. It is the balance point of a triangular plate."
    :calc="['engine' => 'mt-tri', 'tool' => 'triangle', 'fields' => ['given', 'unit', 'x1', 'y1', 'x2', 'y2', 'x3', 'y3'], 'want' => 'centroid']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Sides a, b, c are opposite the angles A, B, C.'],
        ['name' => 'Enter the values', 'text' => 'Every side, angle, height and centre is solved, with a scale drawing.'],
    ]"
    :faqs="[
        ['question' => 'What is the centroid of A(0, 0), B(4, 0), C(1, 3)?', 'answer' => '(1.666666667, 1).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['coords' => 'The coordinates of the vertices']" selected="coords" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="units" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:coords">
            <x-calc.field name="x1" label="A: x₁" value="0" step="any" />
        </div>
        <div data-show-when="given:coords">
            <x-calc.field name="y1" label="A: y₁" value="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:coords">
            <x-calc.field name="x2" label="B: x₂" value="4" step="any" />
        </div>
        <div data-show-when="given:coords">
            <x-calc.field name="y2" label="B: y₂" value="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:coords">
            <x-calc.field name="x3" label="C: x₃" value="1" step="any" />
        </div>
        <div data-show-when="given:coords">
            <x-calc.field name="y3" label="C: y₃" value="3" step="any" />
        </div>
    </div>

    <x-calc.result label="Centroid" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'coords', 'unit' => 'units', 'a' => 5, 'b' => 6, 'c' => 7, 'angA' => 44.4153, 'angB' => 57.1217, 'angC' => 78.463, 'hb' => 4.899, 'x1' => 0, 'y1' => 0, 'x2' => 4, 'y2' => 0, 'x3' => 1, 'y3' => 3],
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
            <li>G = ((x₁ + x₂ + x₃)/3, (y₁ + y₂ + y₃)/3)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
