<x-calc.page
    title="Rectangle Diagonal Angle Calculator - SolveKit"
    description="Free rectangle diagonal angle calculator: the angle between the diagonal and the sides, θ = atan(w ÷ l)."
    lede="Find the angle of the diagonal."
    about="The diagonal makes an angle θ = atan(w/l) with the length and 90° − θ with the width. The two diagonals cross at 2θ and 180° − 2θ."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'l', 'w', 'diag', 'perim', 'area', 'ratio', 'angle'], 'shape' => 'rectangle', 'want' => 'angle']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What angle does the diagonal of an 8 × 5 rectangle make with the long side?', 'answer' => '32.00538321 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['l_w' => 'Length l and width w', 'l_area' => 'Length l and area A', 'w_area' => 'Width w and area A', 'l_perim' => 'Length l and perimeter P', 'w_perim' => 'Width w and perimeter P', 'l_diag' => 'Length l and diagonal d', 'area_perim' => 'Area A and perimeter P', 'diag_perim' => 'Diagonal d and perimeter P', 'area_ratio' => 'Area A and aspect ratio l : w', 'perim_ratio' => 'Perimeter P and aspect ratio l : w', 'diag_ratio' => 'Diagonal d and aspect ratio l : w', 'diag_angle' => 'Diagonal d and angle between diagonal and length']" selected="l_w" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_w,l_area,l_perim,l_diag" hidden>
            <x-calc.field name="l" label="Length l" value="8" min="0" step="any" />
        </div>
        <div data-show-when="given:l_w,w_area,w_perim" hidden>
            <x-calc.field name="w" label="Width w" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_diag,diag_perim,diag_ratio,diag_angle" hidden>
            <x-calc.field name="diag" label="Diagonal d" value="9.43398" min="0" step="any" />
        </div>
        <div data-show-when="given:l_perim,w_perim,area_perim,diag_perim,perim_ratio" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="26" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:l_area,w_area,area_perim,area_ratio" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="40" min="0" step="any" />
        </div>
        <div data-show-when="given:area_ratio,perim_ratio,diag_ratio" hidden>
            <x-calc.field name="ratio" label="Aspect ratio l : w" value="1.6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:diag_angle" hidden>
            <x-calc.field name="angle" label="Angle between diagonal and length (°)" value="32.0054" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Angle between diagonal and length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'l_w', 'unit' => 'cm', 'l' => 8, 'w' => 5, 'diag' => 9.43398, 'perim' => 26, 'area' => 40, 'ratio' => 1.6, 'angle' => 32.0054],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'l' => ['label' => 'Length l'],
            'w' => ['label' => 'Width w'],
            'diag' => ['label' => 'Diagonal d'],
            'perim' => ['label' => 'Perimeter P'],
            'area' => ['label' => 'Area A'],
            'ratio' => ['label' => 'Aspect ratio l : w'],
            'angle' => ['label' => 'Angle between diagonal and length'],
            'circr' => ['label' => 'Circumscribed circle radius'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = atan(w ÷ l)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
