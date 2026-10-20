<x-calc.page
    title="Base of a Triangle Calculator - SolveKit"
    description="Free base of a triangle calculator: b = 2A ÷ h from the area and height."
    lede="Find the base of a triangle."
    about="Since A = ½bh, the base is b = 2A/h: a triangle of area 24 and height 6 has base 8. The same formula gives the height from the area and base."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'base', 'h', 'area'], 'shape' => 'triBH', 'want' => 'base']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'A triangle has area 24 and height 6. How long is its base?', 'answer' => '8 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['base_h' => 'Base b and height h', 'area_h' => 'Area A and height h', 'area_base' => 'Area A and base b']" selected="area_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:base_h,area_base" hidden>
            <x-calc.field name="base" label="Base b" value="8" min="0" step="any" />
        </div>
        <div data-show-when="given:base_h,area_h" hidden>
            <x-calc.field name="h" label="Height h" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:area_h,area_base" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="24" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Base b" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'area_h', 'unit' => 'cm', 'base' => 8, 'h' => 6, 'area' => 24],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'base' => ['label' => 'Base b'],
            'h' => ['label' => 'Height h'],
            'area' => ['label' => 'Area A'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>b = 2A ÷ h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
