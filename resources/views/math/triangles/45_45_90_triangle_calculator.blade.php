<x-calc.page
    title="45 45 90 Triangle Calculator - SolveKit"
    description="Free 45-45-90 triangle calculator: legs and hypotenuse (ratio 1 : 1 : √2), area and perimeter from any one side."
    lede="Solve a 45-45-90 triangle."
    about="A 45-45-90 triangle is an isosceles right triangle: both legs are equal and the hypotenuse is a leg times √2. It is half of a square cut along its diagonal. Also known as isosceles right triangle calculator and isosceles right triangle hypotenuse calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'short', 'long', 'hyp', 'area', 'perim'], 'shape' => 'special', 'want' => 'hyp', 'kind' => '45']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'The legs are 5. How long is the hypotenuse?', 'answer' => '7.071067812 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['short' => 'Short leg a', 'long' => 'Long leg b', 'hyp' => 'Hypotenuse c', 'area' => 'Area', 'perim' => 'Perimeter']" selected="short" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:short" hidden>
            <x-calc.field name="short" label="Short leg a" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:long" hidden>
            <x-calc.field name="long" label="Long leg b" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:hyp" hidden>
            <x-calc.field name="hyp" label="Hypotenuse c" value="7.07107" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="12.5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter" value="17.0711" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Hypotenuse c" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'short', 'unit' => 'cm', 'short' => 5, 'long' => 5, 'hyp' => 7.07107, 'area' => 12.5, 'perim' => 17.0711],
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
            <li>a : a : c = 1 : 1 : √2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
