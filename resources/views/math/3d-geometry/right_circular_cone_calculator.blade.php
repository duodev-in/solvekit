<x-calc.page
    title="Right Circular Cone Calculator - SolveKit"
    description="Free right circular cone calculator: volume, slant height, lateral, base and total surface area from any two measures."
    lede="Solve a cone."
    about="A right circular cone with base radius r and height h has volume πr²h/3 (a third of the cylinder), slant height l = √(r² + h²) and lateral area πrl. With r = 3 and h = 4: l = 5, V = 37.7, A = 75.4. Also known as cone calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'slant', 'd', 'vol', 'lat', 'angle'], 'shape' => 'cone', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a cone with radius 3 and height 4?', 'answer' => '37.69911184 cm³.'],
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

    <x-calc.result label="Volume V" />

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
            <li>V = πr²h ÷ 3</li>
            <li>A = πr(r + l)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
