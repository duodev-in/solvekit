<x-calc.page
    title="Central Angle Calculator - SolveKit"
    description="Free central angle calculator: θ = s ÷ r from the arc length and radius, or from the chord."
    lede="Find the central angle."
    about="A central angle has its vertex at the centre of the circle. Its size in radians is the arc length divided by the radius: an arc of 15 on a circle of radius 10 gives 1.5 rad = 85.94°. It is twice any inscribed angle on the same arc."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'arc', 'area', 'chord', 'sagitta'], 'shape' => 'sector', 'want' => 'theta']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What central angle cuts an arc of 15 on a circle of radius 10?', 'answer' => '85.94366927 °.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_arc' => 'Radius r and arc length s', 'r_chord' => 'Radius r and chord length c', 'r_area' => 'Radius r and sector area A', 'r_sagitta' => 'Radius r and segment height (sagitta)']" selected="r_arc" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_arc,r_chord,r_area,r_sagitta" hidden>
            <x-calc.field name="r" label="Radius r" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:r_arc" hidden>
            <x-calc.field name="arc" label="Arc length s" value="15" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_area" hidden>
            <x-calc.field name="area" label="Sector area A (unit²)" value="75" min="0" step="any" />
        </div>
        <div data-show-when="given:r_chord" hidden>
            <x-calc.field name="chord" label="Chord length c" value="13.6328" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_sagitta" hidden>
            <x-calc.field name="sagitta" label="Segment height (sagitta)" value="2.68311" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Central angle θ" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r_arc', 'unit' => 'cm', 'r' => 10, 'arc' => 15, 'area' => 75, 'chord' => 13.6328, 'sagitta' => 2.68311],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Radius r'],
            'theta' => ['label' => 'Central angle θ'],
            'arc' => ['label' => 'Arc length s'],
            'area' => ['label' => 'Sector area A'],
            'chord' => ['label' => 'Chord length c'],
            'perim' => ['label' => 'Sector perimeter'],
            'segment' => ['label' => 'Segment area'],
            'sagitta' => ['label' => 'Segment height (sagitta)'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>θ = s ÷ r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
