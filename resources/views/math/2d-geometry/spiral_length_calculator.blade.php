<x-calc.page
    title="Spiral Length Calculator - SolveKit"
    description="Free spiral length calculator: the length of a rolled material (paper, tape, hose, carpet) from the diameters and thickness, or of an Archimedean or logarithmic spiral."
    lede="Find the length of a spiral."
    about="A roll of material is an Archimedean spiral whose gap is the material thickness t. With outer diameter D and core diameter d it has N = (D − d)/2t turns and length ≈ πN(D + d)/2; the exact arc length is computed from the spiral's formula. Logarithmic spirals r = ae^(bθ) have length √(1 + b²)/b × (r_end − r_start). Also known as roll length calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'spiral', 'fields' => ['kind', 'dout', 'din', 'thick', 'a', 'b', 'turns', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 30 cm roll of 1 mm material on an 8 cm core?', 'answer' => '6,565.939164 cm.'],
    ]"
>
    <x-calc.select name="kind" label="Spiral" :options="['roll' => 'Roll of material', 'arch' => 'Archimedean r = a + bθ', 'log' => 'Logarithmic r = a e^(bθ)']" selected="roll" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="kind:roll" hidden>
            <x-calc.field name="dout" label="Outer diameter D" value="30" min="0" step="any" />
        </div>
        <div data-show-when="kind:roll" hidden>
            <x-calc.field name="din" label="Core diameter d" value="8" min="0" step="any" />
        </div>
        <div data-show-when="kind:roll" hidden>
            <x-calc.field name="thick" label="Thickness t" value="0.1" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="kind:arch,log" hidden>
            <x-calc.field name="a" label="a (start radius)" value="1" min="0" step="any" />
        </div>
        <div data-show-when="kind:arch,log" hidden>
            <x-calc.field name="b" label="b (growth per radian)" value="0.5" min="0" step="any" />
        </div>
        <div data-show-when="kind:arch,log" hidden>
            <x-calc.field name="turns" label="Turns" value="3" min="0" step="any" />
        </div>
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />

    <x-calc.result label="Spiral length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'roll', 'dout' => 30, 'din' => 8, 'thick' => 0.1, 'a' => 1, 'b' => 0.5, 'turns' => 3, 'unit' => 'cm'],
        'Archimedean' => ['kind' => 'arch', 'dout' => 30, 'din' => 8, 'thick' => 0.1, 'a' => 0, 'b' => 1, 'turns' => 2, 'unit' => 'cm'],
        'Logarithmic' => ['kind' => 'log', 'dout' => 30, 'din' => 8, 'thick' => 0.1, 'a' => 1, 'b' => 0.2, 'turns' => 2, 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'turns' => ['label' => 'Turns'],
            'approx' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L = ∫√(r² + (dr/dθ)²) dθ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
