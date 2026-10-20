<x-calc.page
    title="Cuboid Surface Area Calculator - SolveKit"
    description="Free cuboid surface area calculator: A = 2(lw + lh + wh)."
    lede="Find the surface area of a cuboid."
    about="A cuboid has three pairs of equal rectangular faces, so its surface is twice the sum of the three face areas. Also known as surface area of a rectangle calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'l', 'w', 'h', 'vol', 'surf', 'diag'], 'shape' => 'cuboid', 'want' => 'surf']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the surface area of an 8 × 5 × 4 cuboid?', 'answer' => '184 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['l_w_h' => 'Length l, width w and height h', 'vol_l_w' => 'Volume V, length l and width w', 'surf_l_w' => 'Surface area A, length l and width w', 'diag_l_w' => 'Space diagonal d, length l and width w']" selected="l_w_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_w_h,vol_l_w,surf_l_w,diag_l_w" hidden>
            <x-calc.field name="l" label="Length l" value="8" min="0" step="any" />
        </div>
        <div data-show-when="given:l_w_h,vol_l_w,surf_l_w,diag_l_w" hidden>
            <x-calc.field name="w" label="Width w" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_w_h" hidden>
            <x-calc.field name="h" label="Height h" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_l_w" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="160" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:surf_l_w" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="184" min="0" step="any" />
        </div>
        <div data-show-when="given:diag_l_w" hidden>
            <x-calc.field name="diag" label="Space diagonal d" value="10.247" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Surface area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'l_w_h', 'unit' => 'cm', 'l' => 8, 'w' => 5, 'h' => 4, 'vol' => 160, 'surf' => 184, 'diag' => 10.247],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'l' => ['label' => 'Length l'],
            'w' => ['label' => 'Width w'],
            'h' => ['label' => 'Height h'],
            'vol' => ['label' => 'Volume V'],
            'surf' => ['label' => 'Surface area A'],
            'lat' => ['label' => 'Lateral area (4 sides)'],
            'diag' => ['label' => 'Space diagonal d'],
            'base' => ['label' => 'Base area'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = 2(lw + lh + wh)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
