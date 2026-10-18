<x-calc.page
    title="Miter Angle Calculator - SolveKit"
    description="Free miter angle calculator: the saw angle for each piece of any corner, or for a frame with any number of sides."
    lede="Work out the miter angle for a corner or a frame."
    about="Two pieces meeting at a corner of angle A are each cut at (180° − A) ÷ 2 on the miter saw scale (0° is square): 45° for a square corner. For a frame with n equal sides, that is 180° ÷ n."
    :calc="['engine' => 'con-trig', 'tool' => 'miter', 'fields' => ['mode', 'corner', 'sides']]"
    :how-to="[
        ['name' => 'Measure the corner', 'text' => 'Or count the sides of the frame.'],
    ]"
    :faqs="[
        ['question' => 'What miter for a 90° corner?', 'answer' => '45° on each piece.'],
        ['question' => 'What miter for a 135° bay corner?', 'answer' => '22.5°.'],
        ['question' => 'What miter for a hexagon?', 'answer' => '30°.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['corner' => 'Corner angle', 'sides' => 'Number of sides']" selected="corner" />

    <div data-show-when="mode:corner">
        <x-calc.field name="corner" label="Corner angle" value="90" min="1" max="359" suffix="°" />
    </div>

    <div data-show-when="mode:sides" hidden>
        <x-calc.field name="sides" label="Sides" value="6" min="3" step="1" />
    </div>

    <x-calc.result label="Miter angle" />

    <x-calc.options :examples="[
        'Square corner' => ['mode' => 'corner', 'corner' => 90],
        'Bay window 135°' => ['mode' => 'corner', 'corner' => 135],
        'Hexagon' => ['mode' => 'sides', 'sides' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'corner' => ['label' => 'Corner'],
            'saw' => ['label' => 'Saw setting'],
            'edge' => ['label' => 'From the edge'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>miter = (180° − corner) ÷ 2</li>
            <li>frame: miter = 180° ÷ n</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
