<x-calc.page
    title="Capsule Calculator - SolveKit"
    description="Free capsule calculator: volume and surface area of a cylinder with hemispherical ends (a pill or tank shape)."
    lede="Solve a capsule."
    about="A capsule is a cylinder of radius r and length a with a hemisphere on each end. Its volume is πr²((4/3)r + a) and its surface 2πr(2r + a). Many pressure tanks have this shape."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'len', 'total', 'vol'], 'shape' => 'capsule', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a capsule with radius 3 and cylinder length 10?', 'answer' => '395.8406744 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_len' => 'Radius r and cylinder length a', 'r_total' => 'Radius r and total length a + 2r', 'vol_r' => 'Volume V and radius r']" selected="r_len" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_len,r_total,vol_r" hidden>
            <x-calc.field name="r" label="Radius r" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:r_len" hidden>
            <x-calc.field name="len" label="Cylinder length a" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_total" hidden>
            <x-calc.field name="total" label="Total length a + 2r" value="16" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_r" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="395.841" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r_len', 'unit' => 'cm', 'r' => 3, 'len' => 10, 'total' => 16, 'vol' => 395.841],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Radius r'],
            'len' => ['label' => 'Cylinder length a'],
            'total' => ['label' => 'Total length a + 2r'],
            'vol' => ['label' => 'Volume V'],
            'surf' => ['label' => 'Surface area A'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = πr²((4/3)r + a)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
