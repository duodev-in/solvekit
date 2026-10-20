<x-calc.page
    title="Arc Length Calculator - SolveKit"
    description="Free arc length calculator: s = rθ from the radius and central angle, or from the radius and chord, with the sector area."
    lede="Find the length of an arc."
    about="An arc is part of a circle's circumference. Its length is s = rθ with θ in radians, or 2πr × θ/360° in degrees: a 60° arc of radius 10 is 10.47. You can also start from the chord or the sector area."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'theta', 'arc', 'area', 'chord', 'sagitta'], 'shape' => 'sector', 'want' => 'arc']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How long is a 60° arc of a circle with radius 10?', 'answer' => '10.47197551 cm.'],
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

    <x-calc.result label="Arc length s" />

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
            <li>s = rθ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
