<x-calc.page
    title="Polar to Cartesian Coordinates Calculator - SolveKit"
    description="Free polar to Cartesian calculator: x = r cos θ, y = r sin θ."
    lede="Convert polar to Cartesian."
    about="From (r, θ), x = r cos θ and y = r sin θ. (2, 60°) is (1, √3) ≈ (1, 1.732)."
    :calc="['engine' => 'mt-coord', 'tool' => 'convert_coords', 'fields' => ['dir', 'x', 'y', 'r', 'theta'], 'system' => 'polar']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is (2, 60°) in Cartesian coordinates?', 'answer' => '(1, 1.732050808).'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Cartesian (x, y) → polar (r, θ)', 'from' => 'Polar (r, θ) → Cartesian (x, y)']" selected="from" />

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
        'Example' => ['dir' => 'from', 'x' => '1', 'y' => '1', 'r' => 2, 'theta' => 60],
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
            <li>x = r cos θ</li>
            <li>y = r sin θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
