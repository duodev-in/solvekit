<x-calc.page
    title="Ratios of Directed Line Segments Calculator - SolveKit"
    description="Free directed line segment calculator: the point dividing AB in the ratio m : n, internally or externally (section formula)."
    lede="Divide a segment in a ratio."
    about="The point P that divides A→B in the ratio m : n is P = (nA + mB) ÷ (m + n): it is m/(m + n) of the way from A. External division uses m − n and lands outside the segment. Also known as section formula calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'section', 'fields' => ['x1', 'y1', 'x2', 'y2', 'm', 'n', 'kind']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Which point divides A(1, 2) → B(7, 8) in the ratio 1 : 2?', 'answer' => '(3, 4).'],
    ]"
>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="x1" label="A: x" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="y1" label="A: y" value="2" type="text" inputmode="decimal" />
        <x-calc.field name="x2" label="B: x" value="7" type="text" inputmode="decimal" />
        <x-calc.field name="y2" label="B: y" value="8" type="text" inputmode="decimal" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="m" label="m" value="1" type="text" inputmode="decimal" />
        <x-calc.field name="n" label="n" value="2" type="text" inputmode="decimal" />
        <x-calc.select name="kind" label="Division" :options="['internal' => 'Internal', 'external' => 'External']" selected="internal" />
    </div>

    <x-calc.result label="Point P" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => '1', 'y1' => '2', 'x2' => '7', 'y2' => '8', 'm' => '1', 'n' => '2', 'kind' => 'internal'],
        'External' => ['x1' => '1', 'y1' => '2', 'x2' => '7', 'y2' => '8', 'm' => '3', 'n' => '1', 'kind' => 'external'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'fraction' => ['label' => 'Position'],
            'formula' => ['label' => 'Formula'],
            'check' => ['label' => 'Ratio'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = (mB + nA) ÷ (m + n)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
