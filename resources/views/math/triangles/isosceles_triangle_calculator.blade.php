<x-calc.page
    title="Isosceles Triangle Calculator - SolveKit"
    description="Free isosceles triangle calculator: base, legs, height, apex and base angles, area and perimeter from any two values."
    lede="Solve an isosceles triangle."
    about="An isosceles triangle has two equal legs and equal base angles. The height to the base bisects it, giving two right triangles: h = √(a² − b²/4). Legs 5 and base 6 give height 4 and area 12. Also known as isosceles triangle find A calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'leg', 'base', 'h', 'apex', 'baseAngle', 'area', 'perim'], 'shape' => 'isosceles', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of an isosceles triangle with legs 5 and base 6?', 'answer' => '12 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['leg_base' => 'Leg a (equal sides) and base b', 'base_h' => 'Base b and height to the base h', 'leg_h' => 'Leg a (equal sides) and height to the base h', 'leg_apex' => 'Leg a (equal sides) and apex angle', 'base_baseAngle' => 'Base b and base angle', 'leg_baseAngle' => 'Leg a (equal sides) and base angle', 'base_area' => 'Base b and area A', 'perim_base' => 'Perimeter P and base b']" selected="leg_base" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:leg_base,leg_h,leg_apex,leg_baseAngle" hidden>
            <x-calc.field name="leg" label="Leg a (equal sides)" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:leg_base,base_h,base_baseAngle,base_area,perim_base" hidden>
            <x-calc.field name="base" label="Base b" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:base_h,leg_h" hidden>
            <x-calc.field name="h" label="Height to the base h" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:leg_apex" hidden>
            <x-calc.field name="apex" label="Apex angle (°)" value="73.7398" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:base_baseAngle,leg_baseAngle" hidden>
            <x-calc.field name="baseAngle" label="Base angle (°)" value="53.1301" min="0" step="any" />
        </div>
        <div data-show-when="given:base_area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="12" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:perim_base" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="16" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'leg_base', 'unit' => 'cm', 'leg' => 5, 'base' => 6, 'h' => 4, 'apex' => 73.7398, 'baseAngle' => 53.1301, 'area' => 12, 'perim' => 16],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'leg' => ['label' => 'Leg a (equal sides)'],
            'base' => ['label' => 'Base b'],
            'h' => ['label' => 'Height to the base h'],
            'apex' => ['label' => 'Apex angle'],
            'baseAngle' => ['label' => 'Base angle'],
            'area' => ['label' => 'Area A'],
            'perim' => ['label' => 'Perimeter P'],
            'legH' => ['label' => 'Height to a leg'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>h = √(a² − b²/4)</li>
            <li>A = bh ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
