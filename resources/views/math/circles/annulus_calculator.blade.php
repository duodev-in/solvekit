<x-calc.page
    title="Annulus Calculator - SolveKit"
    description="Free annulus calculator: area, width and circumferences of a ring (washer) between two circles."
    lede="Solve an annulus."
    about="An annulus is the ring between two circles with the same centre. Its area is π(R² − r²) = π(R + r)(R − r). A washer 10 mm across with a 4 mm hole (R = 5, r = 2) has area 66 mm². Also known as ring area calculator and washer area calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'outer', 'inner', 'width', 'area'], 'shape' => 'annulus', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a ring with outer radius 5 and inner radius 2?', 'answer' => '65.97344573 mm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['outer_inner' => 'Outer radius R and inner radius r', 'outer_width' => 'Outer radius R and ring width w', 'inner_width' => 'Inner radius r and ring width w', 'outer_area' => 'Outer radius R and area A', 'inner_area' => 'Inner radius r and area A']" selected="outer_inner" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="mm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:outer_inner,outer_width,outer_area" hidden>
            <x-calc.field name="outer" label="Outer radius R" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:outer_inner,inner_width,inner_area" hidden>
            <x-calc.field name="inner" label="Inner radius r" value="2" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:outer_width,inner_width" hidden>
            <x-calc.field name="width" label="Ring width w" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:outer_area,inner_area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="65.9734" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'outer_inner', 'unit' => 'mm', 'outer' => 5, 'inner' => 2, 'width' => 3, 'area' => 65.9734],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'outer' => ['label' => 'Outer radius R'],
            'inner' => ['label' => 'Inner radius r'],
            'width' => ['label' => 'Ring width w'],
            'area' => ['label' => 'Area A'],
            'outerC' => ['label' => 'Outer circumference'],
            'innerC' => ['label' => 'Inner circumference'],
            'mean' => ['label' => 'Mean radius'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = π(R² − r²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
