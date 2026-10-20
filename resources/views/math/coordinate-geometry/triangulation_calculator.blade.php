<x-calc.page
    title="Triangulation Calculator - SolveKit"
    description="Free triangulation calculator: the distance to a far point from a measured baseline and the angles at its two ends."
    lede="Locate a point by triangulation."
    about="Measure a baseline AB and the angles from each end to a target. The triangle is then fixed (ASA): the law of sines gives the distances from A and B, and the perpendicular distance from the baseline."
    :calc="['engine' => 'mt-coord', 'tool' => 'triangulation', 'fields' => ['base', 'alpha', 'beta']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'From a 100 m baseline the target is at 60° and 50°. How far away is it?', 'answer' => '70.59903776 from the baseline.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="base" label="Baseline AB" value="100" min="0" step="any" />
        <x-calc.field name="alpha" label="Angle at A (°)" value="60" min="0" step="any" />
        <x-calc.field name="beta" label="Angle at B (°)" value="50" min="0" step="any" />
    </div>

    <x-calc.result label="Distance from the baseline" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['base' => 100, 'alpha' => 60, 'beta' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'fromA' => ['label' => 'Distance from A'],
            'fromB' => ['label' => 'Distance from B'],
            'perp' => ['label' => 'Perpendicular distance'],
            'position' => ['label' => 'Position'],
            'apex' => ['label' => 'Angle at the target'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AT = AB sin B ÷ sin(A + B)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
