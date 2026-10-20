<x-calc.page
    title="Diameter of a Cone Calculator - SolveKit"
    description="Free diameter of a cone calculator: the base diameter from the volume and height, or the slant height."
    lede="Find a cone's diameter."
    about="From V = πr²h/3, r = √(3V/πh) and d = 2r. From the slant height and height, r = √(l² − h²)."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'slant', 'd', 'vol', 'lat', 'angle'], 'shape' => 'cone', 'want' => 'd']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What diameter has a cone of volume 100 and height 6?', 'answer' => '7.978845608 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Base radius r and height h', 'd_h' => 'Base diameter and height h', 'r_slant' => 'Base radius r and slant height l', 'h_slant' => 'Height h and slant height l', 'vol_r' => 'Volume V and base radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and base radius r', 'r_angle' => 'Base radius r and half-angle at the apex']" selected="vol_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,r_slant,vol_r,lat_r,r_angle" hidden>
            <x-calc.field name="r" label="Base radius r" value="3.98942" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,h_slant,vol_h" hidden>
            <x-calc.field name="h" label="Height h" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_slant,h_slant" hidden>
            <x-calc.field name="slant" label="Slant height l" value="7.20524" min="0" step="any" />
        </div>
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Base diameter" value="7.97885" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="100" min="0" step="any" />
        </div>
        <div data-show-when="given:lat_r" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="90.3043" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_angle" hidden>
            <x-calc.field name="angle" label="Half-angle at the apex (°)" value="33.6201" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Base diameter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vol_h', 'unit' => 'cm', 'r' => 3.98942, 'h' => 6, 'slant' => 7.20524, 'd' => 7.97885, 'vol' => 100, 'lat' => 90.3043, 'angle' => 33.6201],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Base radius r'],
            'h' => ['label' => 'Height h'],
            'slant' => ['label' => 'Slant height l'],
            'd' => ['label' => 'Base diameter'],
            'vol' => ['label' => 'Volume V'],
            'lat' => ['label' => 'Lateral surface area'],
            'base' => ['label' => 'Base area'],
            'surf' => ['label' => 'Total surface area'],
            'angle' => ['label' => 'Half-angle at the apex'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = 2√(3V ÷ πh)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
