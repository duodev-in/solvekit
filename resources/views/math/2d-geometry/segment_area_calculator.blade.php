<x-calc.page
    title="Segment Area Calculator - SolveKit"
    description="Free circular segment area calculator: the area between a chord and its arc from the radius and angle, chord and height, or radius and height."
    lede="Find the area of a circular segment."
    about="A circular segment is the part of a circle cut off by a chord. Its area is the sector minus the triangle: ½r²(θ − sin θ) with θ in radians. With r = 10 and θ = 60° that is 9.06."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'theta', 'chord', 'sagitta'], 'shape' => 'sector', 'want' => 'segment']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a segment with radius 10 and angle 60°?', 'answer' => '9.058607371 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_theta' => 'Radius r and central angle θ', 'r_sagitta' => 'Radius r and segment height (sagitta)', 'chord_sagitta' => 'Chord length c and segment height (sagitta)', 'r_chord' => 'Radius r and chord length c']" selected="r_theta" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_theta,r_sagitta,r_chord" hidden>
            <x-calc.field name="r" label="Radius r" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:r_theta" hidden>
            <x-calc.field name="theta" label="Central angle θ (°)" value="60" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:chord_sagitta,r_chord" hidden>
            <x-calc.field name="chord" label="Chord length c" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:r_sagitta,chord_sagitta" hidden>
            <x-calc.field name="sagitta" label="Segment height (sagitta)" value="1.33975" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Segment area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r_theta', 'unit' => 'cm', 'r' => 10, 'theta' => 60, 'chord' => 10, 'sagitta' => 1.33975],
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
            <li>A = ½r²(θ − sin θ)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
