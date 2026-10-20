<x-calc.page
    title="Moment of Inertia Calculator - SolveKit"
    description="Free moment of inertia calculator: second moment of area Ix and Iy of rectangles, I-beams, T, C and L sections, pipes and triangles, with the parallel axis theorem."
    lede="Find the area moment of inertia."
    about="The area moment of inertia I = ∫y² dA measures how a section resists bending. For a rectangle Ix = bh³/12; composite sections add the parts with the parallel axis theorem I = I꜀ + Ad². Section moduli and radii of gyration follow. Also known as second moment of area calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'section', 'fields' => ['section', 'unit', 'b', 'h', 't', 'tw', 'dout', 'din', 'offset'], 'want' => 'inertia']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is Ix of an I-beam 10 × 20 with 2 cm flanges and a 1 cm web?', 'answer' => '3,594.666667 cm⁴.'],
        ['question' => 'And of a 10 × 20 rectangle?', 'answer' => '6,666.666667 cm⁴.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="section" label="Section" :options="['rect' => 'Rectangle', 'hollowRect' => 'Hollow rectangle (box)', 'ibeam' => 'I-beam', 'tbeam' => 'T-section', 'channel' => 'C-channel', 'angle' => 'L-angle', 'circle' => 'Solid circle (rod)', 'tube' => 'Hollow circle (pipe)', 'triangle' => 'Triangle']" selected="ibeam" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="section:rect,hollowRect,ibeam,tbeam,channel,angle,triangle" hidden>
            <x-calc.field name="b" label="Width b (flange width)" value="10" min="0" step="any" />
        </div>
        <div data-show-when="section:rect,hollowRect,ibeam,tbeam,channel,angle,triangle" hidden>
            <x-calc.field name="h" label="Height h (total)" value="20" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="section:hollowRect,ibeam,tbeam,channel,angle" hidden>
            <x-calc.field name="t" label="Wall or flange thickness t" value="2" min="0" step="any" />
        </div>
        <div data-show-when="section:ibeam,tbeam,channel,angle" hidden>
            <x-calc.field name="tw" label="Web thickness" value="1" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="section:circle,tube" hidden>
            <x-calc.field name="dout" label="Outer diameter D" value="10" min="0" step="any" />
        </div>
        <div data-show-when="section:tube" hidden>
            <x-calc.field name="din" label="Inner diameter d" value="8" min="0" step="any" />
        </div>
    </div>

    <x-calc.field name="offset" label="Shift the axis by d (optional)" value="0" min="0" step="any" />

    <x-calc.result label="Moment of inertia" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['section' => 'ibeam', 'unit' => 'cm', 'b' => 10, 'h' => 20, 't' => 2, 'tw' => 1, 'dout' => 10, 'din' => 8, 'offset' => 0],
        'Rectangle' => ['section' => 'rect', 'unit' => 'cm', 'b' => 10, 'h' => 20, 't' => 2, 'tw' => 1, 'dout' => 10, 'din' => 8, 'offset' => 0],
        'Shifted' => ['section' => 'rect', 'unit' => 'cm', 'b' => 10, 'h' => 20, 't' => 2, 'tw' => 1, 'dout' => 10, 'din' => 8, 'offset' => 15],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Area'],
            'centroid' => ['label' => 'Centroid'],
            'ix' => ['label' => 'Ix (about the centroid, horizontal)'],
            'iy' => ['label' => 'Iy (about the centroid, vertical)'],
            'modulus' => ['label' => 'Section moduli'],
            'gyration' => ['label' => 'Radii of gyration'],
            'polar' => ['label' => 'Polar moment'],
            'shifted' => ['label' => 'Parallel axis'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>I = Σ(bh³/12 + Ad²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
