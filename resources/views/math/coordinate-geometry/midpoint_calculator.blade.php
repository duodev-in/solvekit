<x-calc.page
    title="Midpoint Calculator - SolveKit"
    description="Free midpoint calculator: the midpoint of a segment ((x₁ + x₂)/2, (y₁ + y₂)/2), exact with fractions."
    lede="Find the midpoint of a segment."
    about="The midpoint is the average of the endpoints. (1, 2) and (4, 7) have midpoint (5/2, 9/2) = (2.5, 4.5)."
    :calc="['engine' => 'mt-coord', 'tool' => 'midpoint', 'fields' => ['x1', 'y1', 'x2', 'y2']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the midpoint of (1, 2) and (4, 7)?', 'answer' => '(5/2, 9/2).'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="x₁" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="y₁" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="x₂" value="4" type="text" inputmode="decimal" />
        <x-calc.field name="y2" label="y₂" value="7" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Midpoint" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '1', 'y1' => '2', 'x2' => '4', 'y2' => '7'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'midpoint' => ['label' => 'Midpoint'],
            'length' => ['label' => 'Segment length'],
            'check' => ['label' => 'Half length'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>M = ((x₁ + x₂)/2, (y₁ + y₂)/2)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
