<x-calc.page
    title="Coin Rotation Paradox - SolveKit"
    description="Coin rotation paradox calculator: how many turns a coin makes rolling around another (R/r + 1 outside, R/r − 1 inside)."
    lede="Explore the coin rotation paradox."
    about="Roll one coin around another of the same size and it turns twice, not once. The rolling coin's centre travels a circle of radius R + r, so it turns (R + r)/r = R/r + 1 times; rolling inside a ring it turns R/r − 1 times. A rim point traces an epicycloid (a cardioid for equal coins)."
    :calc="['engine' => 'mt-tri', 'tool' => 'coin_rotation', 'fields' => ['outer', 'r', 'side']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How many times does a coin turn rolling around an equal coin?', 'answer' => '2.'],
        ['question' => 'And around a coin three times bigger?', 'answer' => '4.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="outer" label="Radius of the fixed coin R" value="1" min="0" step="any" />
        <x-calc.field name="r" label="Radius of the rolling coin r" value="1" min="0" step="any" />
        <x-calc.select name="side" label="Rolling" :options="['outside' => 'Around the outside', 'inside' => 'Inside a ring']" selected="outside" />
    </div>

    <x-calc.result label="Rotations" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['outer' => 1, 'r' => 1, 'side' => 'outside'],
        'Bigger' => ['outer' => 3, 'r' => 1, 'side' => 'outside'],
        'Inside' => ['outer' => 4, 'r' => 1, 'side' => 'inside'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'naive' => ['label' => 'Naive answer R/r'],
            'path' => ['label' => 'Path of the centre'],
            'extra' => ['label' => 'Why'],
            'curve' => ['label' => 'Curve traced'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = R/r ± 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
