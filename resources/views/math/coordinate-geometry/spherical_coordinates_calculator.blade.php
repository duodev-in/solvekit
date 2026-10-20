<x-calc.page
    title="Spherical Coordinates Calculator - SolveKit"
    description="Free spherical coordinates calculator: convert between (x, y, z) and (ρ, θ, φ)."
    lede="Convert spherical coordinates."
    about="Spherical coordinates give the distance ρ from the origin, the azimuth θ around the z-axis and the polar angle φ down from +z: x = ρ sin φ cos θ, y = ρ sin φ sin θ, z = ρ cos φ. (Physics texts swap the names θ and φ.)"
    :calc="['engine' => 'mt-coord', 'tool' => 'convert_coords', 'fields' => ['dir', 'x', 'y', 'z', 'rho', 'theta', 'phi'], 'system' => 'spherical']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is (1, 1, 1) in spherical coordinates?', 'answer' => '(1.732050808, 45°, 54.73561032°).'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Cartesian → spherical', 'from' => 'Spherical → Cartesian']" selected="to" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="x" label="x" value="1" step="any" />
        </div>
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="y" label="y" value="1" step="any" />
        </div>
        <div data-show-when="dir:to" hidden>
            <x-calc.field name="z" label="z" value="1" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="rho" label="ρ" value="2" step="any" />
        </div>
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="theta" label="θ azimuth (°)" value="45" step="any" />
        </div>
        <div data-show-when="dir:from" hidden>
            <x-calc.field name="phi" label="φ from +z (°)" value="60" step="any" />
        </div>
    </div>

    <x-calc.result label="Converted coordinates" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'x' => 1, 'y' => 1, 'z' => 1, 'rho' => 2, 'theta' => 45, 'phi' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'ρ (or x)'],
            'theta' => ['label' => 'θ (or y)'],
            'z' => ['label' => 'φ (or z)'],
            'spherical' => ['label' => 'Related'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ρ = √(x² + y² + z²)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
