<x-calc.page
    title="Cylindrical Coordinates Calculator - SolveKit"
    description="Free cylindrical coordinates calculator: convert between (x, y, z) and (r, θ, z)."
    lede="Convert cylindrical coordinates."
    about="Cylindrical coordinates are polar coordinates in the xy-plane plus the height z: r = √(x² + y²), θ = atan2(y, x), z unchanged."
    :calc="['engine' => 'mt-coord', 'tool' => 'convert_coords', 'fields' => ['dir', 'x', 'y', 'z', 'r', 'theta'], 'system' => 'cylindrical']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is (3, 4, 5) in cylindrical coordinates?', 'answer' => '(5, 53.13010235°, 5).'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Cartesian → cylindrical', 'from' => 'Cylindrical → Cartesian']" selected="to" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="x" label="x" value="3" step="any" />
        </div>
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="y" label="y" value="4" step="any" />
        </div>
        <x-calc.field name="z" label="z" value="5" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="r" label="r" value="5" step="any" />
        </div>
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="theta" label="θ (°)" value="53.13" step="any" />
        </div>
    </div>

    <x-calc.result label="Converted coordinates" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'x' => 3, 'y' => 4, 'z' => 5, 'r' => 5, 'theta' => 53.13],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'r'],
            'theta' => ['label' => 'θ'],
            'z' => ['label' => 'z'],
            'spherical' => ['label' => 'Spherical'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = √(x² + y²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
