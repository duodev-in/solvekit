<x-calc.page
    title="Sector Area Calculator - SolveKit"
    description="Free sector area calculator: A = ½r²θ from the radius and angle, or from the arc length."
    lede="Find the area of a sector."
    about="A sector is a pizza slice of a circle. Its area is the fraction θ/360° of the whole circle: A = πr²θ/360° = ½r²θ (radians) = ½rs. A 60° slice of a 10 inch radius pizza is 52.4 in²."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'theta', 'arc', 'area', 'chord', 'sagitta'], 'shape' => 'sector', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a 60° sector with radius 10?', 'answer' => '52.35987756 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_theta' => 'Radius r and central angle θ', 'r_arc' => 'Radius r and arc length s', 'arc_theta' => 'Arc length s and central angle θ', 'r_area' => 'Radius r and sector area A', 'area_theta' => 'Sector area A and central angle θ', 'r_chord' => 'Radius r and chord length c', 'chord_theta' => 'Chord length c and central angle θ', 'chord_sagitta' => 'Chord length c and segment height (sagitta)', 'r_sagitta' => 'Radius r and segment height (sagitta)']" selected="r_theta" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_theta,r_arc,r_area,r_chord,r_sagitta" hidden>
            <x-calc.field name="r" label="Radius r" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:r_theta,arc_theta,area_theta,chord_theta" hidden>
            <x-calc.field name="theta" label="Central angle θ (°)" value="60" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_arc,arc_theta" hidden>
            <x-calc.field name="arc" label="Arc length s" value="10.472" min="0" step="any" />
        </div>
        <div data-show-when="given:r_area,area_theta" hidden>
            <x-calc.field name="area" label="Sector area A (unit²)" value="52.3599" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_chord,chord_theta,chord_sagitta" hidden>
            <x-calc.field name="chord" label="Chord length c" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:chord_sagitta,r_sagitta" hidden>
            <x-calc.field name="sagitta" label="Segment height (sagitta)" value="1.33975" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Sector area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r_theta', 'unit' => 'cm', 'r' => 10, 'theta' => 60, 'arc' => 10.472, 'area' => 52.3599, 'chord' => 10, 'sagitta' => 1.33975],
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
            <li>A = ½r²θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
