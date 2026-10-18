<x-calc.page
    title="SAG Calculator - SolveKit"
    description="Free sag (sagitta) calculator: the height of a circular arc from its radius and chord, or the radius or chord from the other two, with arc length and segment area."
    lede="Work out the sagitta (sag) of an arc from the radius and chord."
    about="The sagitta s is the height of an arc above its chord: s = r − √(r² − (c ÷ 2)²). From the chord and sagitta, r = ((c ÷ 2)² + s²) ÷ 2s; from the radius and sagitta, c = 2√(2rs − s²). It is used for arched openings, curved forms, lens and mirror depths and tank heads."
    :calc="['engine' => 'con-trig', 'tool' => 'sagitta', 'fields' => ['solve', 'units', 'radius', 'chord', 'sag']]"
    :how-to="[
        ['name' => 'Choose what to find', 'text' => 'Sagitta, radius or chord.'],
        ['name' => 'Enter the other two', 'text' => 'In one unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the sagitta of a 36 in chord on a 24 in radius?', 'answer' => '8.13 in.'],
        ['question' => 'What radius gives a 6 in rise over 36 in?', 'answer' => '30 in.'],
        ['question' => 'Is sagitta the same as sag?', 'answer' => 'Yes for a circular arc: it is the height of the arc above its chord.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="solve" label="Find" :options="['sagitta' => 'Sagitta (from radius and chord)', 'radius' => 'Radius (from chord and sagitta)', 'chord' => 'Chord (from radius and sagitta)']" selected="sagitta" />
        <x-calc.select name="units" label="Units" :options="['in' => 'in', 'ft' => 'ft', 'mm' => 'mm', 'm' => 'm']" selected="in" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="solve:sagitta,chord">
            <x-calc.field name="radius" label="Radius" value="24" min="0" />
        </div>
        <div data-show-when="solve:sagitta,radius">
            <x-calc.field name="chord" label="Chord (span)" value="36" min="0" />
        </div>
        <div data-show-when="solve:radius,chord" hidden>
            <x-calc.field name="sag" label="Sagitta (height)" value="6" min="0" />
        </div>
    </div>

    <x-calc.result label="Sagitta" />

    <x-calc.options :examples="[
        'Radius 24, chord 36 in' => ['solve' => 'sagitta', 'units' => 'in', 'radius' => 24, 'chord' => 36],
        'Chord 36, rise 6 in' => ['solve' => 'radius', 'units' => 'in', 'chord' => 36, 'sag' => 6],
        'Radius 1.5 m, sag 0.2 m' => ['solve' => 'chord', 'units' => 'm', 'radius' => 1.5, 'sag' => 0.2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'sagitta' => ['label' => 'Sagitta'],
            'radius' => ['label' => 'Radius'],
            'chord' => ['label' => 'Chord'],
            'arc' => ['label' => 'Arc length'],
            'area' => ['label' => 'Segment area'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>s = r − √(r² − (c ÷ 2)²)</li>
            <li>r = ((c ÷ 2)² + s²) ÷ 2s</li>
            <li>c = 2√(2rs − s²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
