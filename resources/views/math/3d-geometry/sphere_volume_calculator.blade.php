<x-calc.page
    title="Sphere Volume Calculator - SolveKit"
    description="Free sphere volume calculator: V = (4/3)πr³, in cm³, litres and gallons."
    lede="Find the volume of a sphere."
    about="V = (4/3)πr³: doubling the radius multiplies the volume by eight. A sphere 10 cm across holds 523.6 cm³."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'circ', 'surf', 'vol'], 'shape' => 'sphere', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a sphere 10 cm across?', 'answer' => '523.5987756 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter d', 'circ' => 'Circumference (great circle)', 'surf' => 'Surface area A', 'vol' => 'Volume V']" selected="d" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter d" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ" hidden>
            <x-calc.field name="circ" label="Circumference (great circle)" value="31.4159" min="0" step="any" />
        </div>
        <div data-show-when="given:surf" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="314.159" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="523.599" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'd', 'unit' => 'cm', 'r' => 5, 'd' => 10, 'circ' => 31.4159, 'surf' => 314.159, 'vol' => 523.599],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Radius r'],
            'd' => ['label' => 'Diameter d'],
            'circ' => ['label' => 'Circumference (great circle)'],
            'surf' => ['label' => 'Surface area A'],
            'vol' => ['label' => 'Volume V'],
            'ratio' => ['label' => 'Surface to volume ratio'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = (4/3)πr³ = πd³/6</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
