<x-calc.page
    title="Volume of a Hemisphere Calculator - SolveKit"
    description="Free volume of a hemisphere calculator: V = (2/3)πr³, with litres and gallons."
    lede="Find the volume of a hemisphere."
    about="A hemisphere holds half a sphere: (2/3)πr³. A bowl of radius 10 cm holds 2.09 L when full."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'vol', 'curved', 'surf'], 'shape' => 'hemisphere', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How much does a hemispherical bowl of radius 10 cm hold?', 'answer' => '2,094.395102 cm³ = 2.0943951 L = 0.55328065 US gal = 0.073962865 ft³ = 0.0027393654 yd³ = 2,094.3951 cm³ (mL) = 127.80783 in³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter', 'vol' => 'Volume V', 'curved' => 'Curved surface area', 'surf' => 'Total surface area']" selected="r" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter" value="20" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="2094.4" min="0" step="any" />
        </div>
        <div data-show-when="given:curved" hidden>
            <x-calc.field name="curved" label="Curved surface area (unit²)" value="628.319" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:surf" hidden>
            <x-calc.field name="surf" label="Total surface area (unit²)" value="942.478" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r', 'unit' => 'cm', 'r' => 10, 'd' => 20, 'vol' => 2094.4, 'curved' => 628.319, 'surf' => 942.478],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Radius r'],
            'd' => ['label' => 'Diameter'],
            'vol' => ['label' => 'Volume V'],
            'curved' => ['label' => 'Curved surface area'],
            'base' => ['label' => 'Base (flat) area'],
            'surf' => ['label' => 'Total surface area'],
            'centroid' => ['label' => 'Centroid height'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = (2/3)πr³</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
