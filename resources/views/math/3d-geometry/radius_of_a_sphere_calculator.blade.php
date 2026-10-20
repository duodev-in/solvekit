<x-calc.page
    title="Radius of a Sphere Calculator - SolveKit"
    description="Free radius of a sphere calculator: r from the volume, surface area, diameter or circumference."
    lede="Find the radius of a sphere."
    about="From the volume, r = ∛(3V/4π); from the surface area, r = √(A/4π). A 1-litre sphere has radius 6.2 cm."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'd', 'circ', 'surf', 'vol'], 'shape' => 'sphere', 'want' => 'r']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What radius holds 1,000 cm³?', 'answer' => '6.203504909 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Radius r', 'd' => 'Diameter d', 'circ' => 'Circumference (great circle)', 'surf' => 'Surface area A', 'vol' => 'Volume V']" selected="vol" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Radius r" value="6.2035" min="0" step="any" />
        </div>
        <div data-show-when="given:d" hidden>
            <x-calc.field name="d" label="Diameter d" value="12.407" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circ" hidden>
            <x-calc.field name="circ" label="Circumference (great circle)" value="38.9778" min="0" step="any" />
        </div>
        <div data-show-when="given:surf" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="483.598" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="1000" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Radius r" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vol', 'unit' => 'cm', 'r' => 6.2035, 'd' => 12.407, 'circ' => 38.9778, 'surf' => 483.598, 'vol' => 1000],
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
            <li>r = ∛(3V/4π)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
