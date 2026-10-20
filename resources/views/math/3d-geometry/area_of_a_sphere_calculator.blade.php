<x-calc.page
    title="Area of a Sphere Calculator - SolveKit"
    description="Free surface area of a sphere calculator: A = 4πr² from the radius, diameter or volume."
    lede="Find the surface area of a sphere."
    about="The surface area of a sphere is four times the area of its great circle: 4πr². The Earth (r = 6,371 km) has 510 million km²."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'circ', 'surf', 'vol'], 'shape' => 'sphere', 'want' => 'surf']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the surface area of a sphere with radius 11?', 'answer' => '1,520.530844 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter d', 'circ' => 'Circumference (great circle)', 'surf' => 'Surface area A', 'vol' => 'Volume V']" selected="r" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="11" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter d" value="22" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ" hidden>
            <x-calc.field name="circ" label="Circumference (great circle)" value="69.115" min="0" step="any" />
        </div>
        <div data-show-when="given:surf" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="1520.53" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="5575.28" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Surface area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r', 'unit' => 'cm', 'r' => 11, 'd' => 22, 'circ' => 69.115, 'surf' => 1520.53, 'vol' => 5575.28],
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
            <li>A = 4πr²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
