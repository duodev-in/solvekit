<x-calc.page
    title="Circle Theorems Calculator - SolveKit"
    description="Free circle theorems calculator: inscribed angles, intersecting chords, two secants and tangent–secant lengths."
    lede="Apply a circle theorem."
    about="Circle theorems link angles and lengths: an inscribed angle is half the central angle on the same arc; intersecting chords satisfy ab = cd; secants from one point satisfy a(a + b) = c(c + d); and a tangent t satisfies t² = a(a + b). Leave the unknown blank."
    :calc="['engine' => 'mt-tri', 'tool' => 'circle_theorems', 'fields' => ['theorem', 'central', 'inscribed', 'ca', 'cb', 'cc', 'cd']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Two chords cross; one is cut into 3 and 8, the other has a part of 4. What is the other part?', 'answer' => '6.'],
    ]"
>
    <x-calc.select name="theorem" label="Theorem" :options="['inscribed' => 'Inscribed and central angles', 'chords' => 'Intersecting chords', 'secants' => 'Two secants from a point', 'tangent' => 'Tangent and secant from a point']" selected="chords" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="theorem:inscribed" hidden>
            <x-calc.field name="central" label="Central angle (°), blank if unknown" value="" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="theorem:inscribed" hidden>
            <x-calc.field name="inscribed" label="Inscribed angle (°), blank if unknown" value="35" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="theorem:chords,secants,tangent" hidden>
            <x-calc.field name="ca" label="First value (a, or t for the tangent)" value="3" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="theorem:chords,secants,tangent" hidden>
            <x-calc.field name="cb" label="Second value (b)" value="8" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="theorem:chords,secants,tangent" hidden>
            <x-calc.field name="cc" label="Third value (c)" value="4" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="theorem:chords,secants" hidden>
            <x-calc.field name="cd" label="Fourth value (d)" value="" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['theorem' => 'chords', 'central' => '', 'inscribed' => '35', 'ca' => '3', 'cb' => '8', 'cc' => '4', 'cd' => ''],
        'Tangent' => ['theorem' => 'tangent', 'central' => '', 'inscribed' => '35', 'ca' => '', 'cb' => '4', 'cc' => '5', 'cd' => ''],
        'Angles' => ['theorem' => 'inscribed', 'central' => '', 'inscribed' => '35', 'ca' => '3', 'cb' => '8', 'cc' => '4', 'cd' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'arc' => ['label' => 'Values'],
            'other' => ['label' => 'Check'],
            'semicircle' => ['label' => 'Rule'],
            'cyclic' => ['label' => 'Related fact'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ab = cd</li>
            <li>t² = a(a + b)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
