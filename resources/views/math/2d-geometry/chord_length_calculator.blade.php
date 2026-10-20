<x-calc.page
    title="Chord Length Calculator - SolveKit"
    description="Free chord length calculator: c = 2r sin(θ/2) from the radius and angle, or from the radius and the segment height (sagitta)."
    lede="Find the length of a chord."
    about="A chord joins two points on a circle. With radius r and central angle θ its length is 2r sin(θ/2); with the segment height h (sagitta) it is 2√(2rh − h²). The arc over the chord is always a little longer."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'theta', 'arc', 'chord', 'sagitta'], 'shape' => 'sector', 'want' => 'chord']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How long is the chord of a 60° angle in a circle of radius 10?', 'answer' => '10 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_theta' => 'Radius r and central angle θ', 'r_sagitta' => 'Radius r and segment height (sagitta)', 'r_arc' => 'Radius r and arc length s', 'chord_sagitta' => 'Chord length c and segment height (sagitta)', 'r_chord' => 'Radius r and chord length c']" selected="r_theta" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_theta,r_sagitta,r_arc,r_chord" hidden>
            <x-calc.field name="r" label="Radius r" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:r_theta" hidden>
            <x-calc.field name="theta" label="Central angle θ (°)" value="60" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_arc" hidden>
            <x-calc.field name="arc" label="Arc length s" value="10.472" min="0" step="any" />
        </div>
        <div data-show-when="given:chord_sagitta,r_chord" hidden>
            <x-calc.field name="chord" label="Chord length c" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_sagitta,chord_sagitta" hidden>
            <x-calc.field name="sagitta" label="Segment height (sagitta)" value="1.33975" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Chord length c" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r_theta', 'unit' => 'cm', 'r' => 10, 'theta' => 60, 'arc' => 10.472, 'chord' => 10, 'sagitta' => 1.33975],
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
            <li>c = 2r sin(θ/2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
