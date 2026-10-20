<x-calc.page
    title="Endpoint Calculator - SolveKit"
    description="Free endpoint calculator: find the other endpoint of a segment from one endpoint and the midpoint, B = 2M − A."
    lede="Find the missing endpoint."
    about="Since the midpoint is the average, B = 2M − A. With A(1, 2) and midpoint (3, 5) the other end is (5, 8)."
    :calc="['engine' => 'mt-coord', 'tool' => 'midpoint', 'fields' => ['x1', 'y1', 'mx', 'my'], 'mode' => 'endpoint']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'A(1, 2) has midpoint (3, 5) with B. Where is B?', 'answer' => '(5, 8).'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="Endpoint x₁" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="Endpoint y₁" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="mx" label="Midpoint x" value="3" type="text" inputmode="decimal" />
        <x-calc.field name="my" label="Midpoint y" value="5" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Other endpoint" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '1', 'y1' => '2', 'mx' => '3', 'my' => '5'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'midpoint' => ['label' => 'Midpoint'],
            'length' => ['label' => 'Segment length'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>B = 2M − A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
