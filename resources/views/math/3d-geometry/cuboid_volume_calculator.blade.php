<x-calc.page
    title="Cuboid Volume Calculator - SolveKit"
    description="Free cuboid volume calculator: V = l × w × h, with litres and gallons."
    lede="Find the volume of a cuboid."
    about="Multiply the three dimensions: a 50 × 30 × 40 cm tank holds 60,000 cm³ = 60 L."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'l', 'w', 'h', 'vol', 'surf', 'diag'], 'shape' => 'cuboid', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How much does a 50 × 30 × 40 cm tank hold?', 'answer' => '60,000 cm³ = 60 L = 15.850323 US gal = 2.11888 ft³ = 0.078477037 yd³ = 60,000 cm³ (mL) = 3,661.4246 in³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['l_w_h' => 'Length l, width w and height h', 'vol_l_w' => 'Volume V, length l and width w', 'surf_l_w' => 'Surface area A, length l and width w', 'diag_l_w' => 'Space diagonal d, length l and width w']" selected="l_w_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_w_h,vol_l_w,surf_l_w,diag_l_w" hidden>
            <x-calc.field name="l" label="Length l" value="50" min="0" step="any" />
        </div>
        <div data-show-when="given:l_w_h,vol_l_w,surf_l_w,diag_l_w" hidden>
            <x-calc.field name="w" label="Width w" value="30" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_w_h" hidden>
            <x-calc.field name="h" label="Height h" value="40" min="0" step="any" />
        </div>
        <div data-show-when="given:vol_l_w" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="60000" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:surf_l_w" hidden>
            <x-calc.field name="surf" label="Surface area A (unit²)" value="9400" min="0" step="any" />
        </div>
        <div data-show-when="given:diag_l_w" hidden>
            <x-calc.field name="diag" label="Space diagonal d" value="70.7107" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'l_w_h', 'unit' => 'cm', 'l' => 50, 'w' => 30, 'h' => 40, 'vol' => 60000, 'surf' => 9400, 'diag' => 70.7107],
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
            <li>V = lwh</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
