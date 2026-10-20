<x-calc.page
    title="Truncated Cone Calculator - SolveKit"
    description="Free truncated cone (frustum) calculator: volume, slant height and surface areas from the two radii and the height."
    lede="Solve a truncated cone."
    about="A truncated cone (frustum) is a cone with its top cut off parallel to the base. Its volume is πh(R² + Rr + r²)/3. A bucket with radii 15 and 10 cm and height 30 cm holds 14.9 L. Also known as truncated cone volume calculator and frustum calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'R', 'r', 'h', 'slant', 'vol'], 'shape' => 'frustum', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How much does a bucket with radii 15 and 10 cm and height 30 cm hold?', 'answer' => '14,922.5651 cm³ = 14.922565 L = 3.9421247 US gal = 0.52698541 ft³ = 0.019517978 yd³ = 14,922.565 cm³ (mL) = 910.63079 in³.'],
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

    <x-calc.result label="Volume V" />

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
            <li>V = πh(R² + Rr + r²) ÷ 3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
