<x-calc.page
    title="Distance from Point to Line Calculator - SolveKit"
    description="Free distance from a point to a line calculator: |ax₀ + by₀ − c| ÷ √(a² + b²), exactly, with the foot of the perpendicular."
    lede="Find the distance from a point to a line."
    about="The shortest distance from a point to a line is along the perpendicular. For 3x + 4y = 10 and the point (5, 5): |15 + 20 − 10| ÷ 5 = 5, meeting the line at (2, 1)."
    :calc="['engine' => 'mt-coord', 'tool' => 'point_line', 'fields' => ['eq', 'px', 'py']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'How far is (5, 5) from 3x + 4y = 10?', 'answer' => '5.'],
    ]"
>
    <x-calc.field name="eq" label="Line" value="3x + 4y = 10" type="text" inputmode="text" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="px" label="Point x" value="5" type="text" inputmode="decimal" />
        <x-calc.field name="py" label="Point y" value="5" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['eq' => '3x + 4y = 10', 'px' => '5', 'py' => '5'],
        'Root' => ['eq' => 'y = 2x + 1', 'px' => '0', 'py' => '0'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'distance' => ['label' => 'Distance'],
            'foot' => ['label' => 'Foot of the perpendicular'],
            'line' => ['label' => 'Line'],
            'side' => ['label' => 'Side'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>d = |ax₀ + by₀ − c| ÷ √(a² + b²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
