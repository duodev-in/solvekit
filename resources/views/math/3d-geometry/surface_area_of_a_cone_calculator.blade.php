<x-calc.page
    title="Surface Area of a Cone Calculator - SolveKit"
    description="Free surface area of a cone calculator: A = πr(r + l), base plus curved surface."
    lede="Find a cone's surface area."
    about="Total surface = base πr² + curved πrl = πr(r + l). With r = 3, h = 4: 24π = 75.4."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'slant', 'd', 'vol', 'lat', 'angle'], 'shape' => 'cone', 'want' => 'surf']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the total surface area of a cone with radius 3 and height 4?', 'answer' => '75.39822369 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Base radius r and height h', 'd_h' => 'Base diameter and height h', 'r_slant' => 'Base radius r and slant height l', 'h_slant' => 'Height h and slant height l', 'vol_r' => 'Volume V and base radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and base radius r', 'r_angle' => 'Base radius r and half-angle at the apex']" selected="r_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,r_slant,vol_r,lat_r,r_angle" hidden>
            <x-calc.field name="r" label="Base radius r" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,d_h,h_slant,vol_h" hidden>
            <x-calc.field name="h" label="Height h" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_slant,h_slant" hidden>
            <x-calc.field name="slant" label="Slant height l" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:d_h" hidden>
            <x-calc.field name="d" label="Base diameter" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vol_r,vol_h" hidden>
            <x-calc.field name="vol" label="Volume V (unit³)" value="37.6991" min="0" step="any" />
        </div>
        <div data-show-when="given:lat_r" hidden>
            <x-calc.field name="lat" label="Lateral surface area (unit²)" value="47.1239" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_angle" hidden>
            <x-calc.field name="angle" label="Half-angle at the apex (°)" value="36.8699" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Total surface area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r_h', 'unit' => 'cm', 'r' => 3, 'h' => 4, 'slant' => 5, 'd' => 6, 'vol' => 37.6991, 'lat' => 47.1239, 'angle' => 36.8699],
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
            <li>A = πr(r + l)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
