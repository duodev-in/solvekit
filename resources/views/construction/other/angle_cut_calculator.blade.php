<x-calc.page
    title="Angle Cut Calculator - SolveKit"
    description="Free angle cut calculator: miter angle for polygon frames, and miter and bevel saw settings for crown molding laid flat."
    lede="Work out saw angles for frames and crown molding."
    about="An n-sided frame needs each joint cut at 180° ÷ n. Crown molding laid flat on a compound miter saw with spring angle S in a corner of angle A needs miter = atan(sin S ÷ tan(A ÷ 2)) and bevel = asin(cos S × cos(A ÷ 2)): for 38° crown in a 90° corner, 31.6° and 33.9°."
    :calc="['engine' => 'con-trig', 'tool' => 'angle_cut', 'fields' => ['mode', 'sides', 'spring', 'corner']]"
    :how-to="[
        ['name' => 'Choose frame or crown', 'text' => 'And enter the sides or angles.'],
    ]"
    :faqs="[
        ['question' => 'What angle for an octagon?', 'answer' => '22.5°.'],
        ['question' => 'What are the saw settings for 38° crown in a square corner?', 'answer' => 'Miter 31.6°, bevel 33.9° (laid flat).'],
        ['question' => 'What is the spring angle?', 'answer' => 'The angle between the crown\'s back and the wall.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Cut" :options="['polygon' => 'Polygon frame', 'crown' => 'Crown molding']" selected="polygon" />

    <div data-show-when="mode:polygon">
        <x-calc.field name="sides" label="Number of sides" value="8" min="3" step="1" />
    </div>

    <div data-show-when="mode:crown" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="spring" label="Spring angle" :options="['38' => '38° (52/38 crown)', '45' => '45°', '52' => '52°']" selected="38" />
            <x-calc.field name="corner" label="Wall corner angle" value="90" min="1" max="179" suffix="°" />
        </div>
    </div>

    <x-calc.result label="Miter angle" />

    <x-calc.options :examples="[
        'Octagon' => ['mode' => 'polygon', 'sides' => 8],
        'Hexagon' => ['mode' => 'polygon', 'sides' => 6],
        '38° crown, 90° corner' => ['mode' => 'crown', 'spring' => '38', 'corner' => 90],
        '45° crown, 135° corner' => ['mode' => 'crown', 'spring' => '45', 'corner' => 135],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:polygon">
            <x-calc.rows heading="Details" :rows="[
                'miter' => ['label' => 'Miter'],
                'interior' => ['label' => 'Interior corner'],
                'from_edge' => ['label' => 'From the edge'],
            ]" />
        </div>
        <div data-show-when="mode:crown" hidden>
            <x-calc.rows heading="Details" :rows="[
                'miter' => ['label' => 'Miter'],
                'bevel' => ['label' => 'Bevel'],
                'nested' => ['label' => 'Nested method'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>frame: miter = 180° ÷ n</li>
            <li>crown: miter = atan(sin S ÷ tan(A/2)), bevel = asin(cos S cos(A/2))</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
