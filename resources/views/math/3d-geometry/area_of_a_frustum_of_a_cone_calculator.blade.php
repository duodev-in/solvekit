<x-calc.page
    title="Area of a Frustum of a Cone Calculator - SolveKit"
    description="Free frustum surface area calculator: lateral area π(R + r)l and total area with both ends."
    lede="Find the surface area of a frustum."
    about="The curved surface of a frustum is π(R + r)l with slant height l = √((R − r)² + h²); add πR² and πr² for the two ends."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'R', 'r', 'h', 'slant', 'vol'], 'shape' => 'frustum', 'want' => 'surf']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the lateral area of a frustum with radii 15 and 10 and height 30?', 'answer' => '2,388.69526 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['R_r_h' => 'Bottom radius R, top radius r and height h', 'R_r_slant' => 'Bottom radius R, top radius r and slant height', 'R_r_vol' => 'Bottom radius R, top radius r and volume V']" selected="R_r_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:R_r_h,R_r_slant,R_r_vol" hidden>
            <x-calc.field name="R" label="Bottom radius R" value="15" min="0" step="any" />
        </div>
        <div data-show-when="given:R_r_h,R_r_slant,R_r_vol" hidden>
            <x-calc.field name="r" label="Top radius r" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:R_r_h" hidden>
            <x-calc.field name="h" label="Height h" value="30" min="0" step="any" />
        </div>
        <div data-show-when="given:R_r_slant" hidden>
            <x-calc.field name="slant" label="Slant height" value="30.4138" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:R_r_vol" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="14922.6" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Total surface area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'R_r_h', 'unit' => 'cm', 'R' => 15, 'r' => 10, 'h' => 30, 'slant' => 30.4138, 'vol' => 14922.6],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'R' => ['label' => 'Bottom radius R'],
            'r' => ['label' => 'Top radius r'],
            'h' => ['label' => 'Height h'],
            'slant' => ['label' => 'Slant height'],
            'vol' => ['label' => 'Volume V'],
            'lat' => ['label' => 'Lateral surface area'],
            'surf' => ['label' => 'Total surface area'],
            'top' => ['label' => 'Top area'],
            'bottom' => ['label' => 'Bottom area'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = π(R + r)l + π(R² + r²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
