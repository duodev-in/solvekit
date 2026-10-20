<x-calc.page
    title="Special Right Triangles Calculator - SolveKit"
    description="Free special right triangles calculator: 30-60-90 and 45-45-90 triangles from any one side."
    lede="Solve a special right triangle."
    about="The two special right triangles have side ratios you can remember: 30-60-90 is 1 : √3 : 2 and 45-45-90 is 1 : 1 : √2. They give exact trig values such as sin 30° = 1/2 and cos 45° = √2/2. Also known as triangle ratio calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['kind', 'given', 'unit', 'short', 'long', 'hyp', 'area', 'perim'], 'shape' => 'special', 'want' => 'short']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'A 30-60-90 triangle has hypotenuse 10. What are the legs?', 'answer' => '5 cm and 8.660254038 cm.'],
    ]"
>
    <x-calc.select name="kind" label="Triangle" :options="['30' => '30-60-90', '45' => '45-45-90']" selected="30" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['short' => 'Short leg a', 'long' => 'Long leg b', 'hyp' => 'Hypotenuse c', 'area' => 'Area', 'perim' => 'Perimeter']" selected="hyp" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:short" hidden>
            <x-calc.field name="short" label="Short leg a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:long" hidden>
            <x-calc.field name="long" label="Long leg b" value="8.66025" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:hyp" hidden>
            <x-calc.field name="hyp" label="Hypotenuse c" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="21.6506" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter" value="23.6603" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Short leg a" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => '30', 'given' => 'hyp', 'unit' => 'cm', 'short' => 5, 'long' => 8.66025, 'hyp' => 10, 'area' => 21.6506, 'perim' => 23.6603],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'short' => ['label' => 'Short leg a'],
            'long' => ['label' => 'Long leg b'],
            'hyp' => ['label' => 'Hypotenuse c'],
            'area' => ['label' => 'Area'],
            'perim' => ['label' => 'Perimeter'],
            'h' => ['label' => 'Height to the hypotenuse'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 : √3 : 2</li>
            <li>1 : 1 : √2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
