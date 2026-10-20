<x-calc.page
    title="Polar Coordinates Calculator - SolveKit"
    description="Free polar coordinates calculator: convert between Cartesian (x, y) and polar (r, θ), with exact r."
    lede="Convert to and from polar coordinates."
    about="Polar coordinates give a point by its distance r from the origin and its angle θ from the positive x-axis: r = √(x² + y²), θ = atan2(y, x); back again with x = r cos θ, y = r sin θ. Also known as polar to rectangular coordinates calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'convert_coords', 'fields' => ['dir', 'x', 'y', 'r', 'theta'], 'system' => 'polar']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is (1, 1) in polar coordinates?', 'answer' => '(√2, 45°).'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Cartesian (x, y) → polar (r, θ)', 'from' => 'Polar (r, θ) → Cartesian (x, y)']" selected="to" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="x" label="x" value="1" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="y" label="y" value="1" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="r" label="r" value="2" step="any" />
        </div>
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="theta" label="θ (°)" value="60" step="any" />
        </div>
    </div>

    <x-calc.result label="Converted coordinates" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'x' => '1', 'y' => '1', 'r' => 2, 'theta' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'r'],
            'theta' => ['label' => 'θ'],
            'other' => ['label' => 'Other forms'],
            'back' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = √(x² + y²)</li>
            <li>θ = atan2(y, x)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
