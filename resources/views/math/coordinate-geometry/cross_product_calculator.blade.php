<x-calc.page
    title="Cross Product Calculator - SolveKit"
    description="Free cross product calculator: u × v of two 3D vectors, its length (parallelogram area) and the check that it is perpendicular to both."
    lede="Find the cross product."
    about="The cross product of two 3D vectors is perpendicular to both, with length |u||v| sin θ, the area of the parallelogram they span. ⟨1, 2, 3⟩ × ⟨4, 5, 6⟩ = ⟨−3, 6, −3⟩."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u', 'v'], 'op' => 'cross']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is ⟨1, 2, 3⟩ × ⟨4, 5, 6⟩?', 'answer' => '⟨−3, 6, −3⟩.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="u" label="Vector u" value="1, 2, 3" type="text" inputmode="text" />
        <x-calc.field name="v" label="Vector v" value="4, 5, 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Cross product u × v" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '1, 2, 3', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1'],
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
            <li>u × v = (u₂v₃ − u₃v₂, u₃v₁ − u₁v₃, u₁v₂ − u₂v₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
