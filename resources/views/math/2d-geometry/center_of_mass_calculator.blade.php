<x-calc.page
    title="Center of Mass Calculator - SolveKit"
    description="Free center of mass calculator: the balance point of point masses in 1D or 2D, x̄ = Σmx ÷ Σm."
    lede="Find the centre of mass."
    about="The centre of mass is the mass-weighted average position: x̄ = Σmᵢxᵢ ÷ Σmᵢ and the same for y. Type one point per line as x, y, mass (or x, mass for points on a line). Also known as centre of mass calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'center_mass', 'fields' => ['points']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'Where is the centre of mass of 2 kg at (0, 0), 1 kg at (4, 0) and 1 kg at (0, 3)?', 'answer' => '(1, 0.75).'],
    ]"
>
    <x-calc.textarea name="points" label="Points: x, y, mass (one per line)" value="0, 0, 2
4, 0, 1
0, 3, 1" rows="5" />

    <x-calc.result label="Centre of mass" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['points' => '0, 0, 2
4, 0, 1
0, 3, 1'],
        'Seesaw' => ['points' => '-2, 30
3, 20'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'mass' => ['label' => 'Total mass'],
            'x' => ['label' => 'x̄'],
            'y' => ['label' => 'ȳ'],
            'moment' => ['label' => 'Moments'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>x̄ = Σmx ÷ Σm</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
