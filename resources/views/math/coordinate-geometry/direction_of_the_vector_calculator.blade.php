<x-calc.page
    title="Direction of the Vector Calculator - SolveKit"
    description="Free vector direction calculator: the direction angle of a 2D vector, or the direction angles and cosines of a 3D vector."
    lede="Find a vector's direction."
    about="In 2D the direction is the angle θ = atan2(y, x) from the positive x-axis. In 3D the direction angles α, β, γ satisfy cos α = x/|u| and so on, with cos²α + cos²β + cos²γ = 1."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u'], 'op' => 'direction']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What direction does ⟨1, 2, 2⟩ point?', 'answer' => '70.528779°, 48.189685°, 48.189685°.'],
    ]"
>
    <x-calc.field name="u" label="Vector u" value="1, 2, 2" type="text" inputmode="text" />

    <x-calc.result label="Direction angles" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '1, 2, 2', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1'],
        '2D' => ['u' => '-3, 4', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'result' => ['label' => 'Result'],
            'u' => ['label' => 'u'],
            'v' => ['label' => 'v'],
            'extra' => ['label' => 'More'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>cos α = x ÷ |u|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
