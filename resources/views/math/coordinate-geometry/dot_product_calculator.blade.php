<x-calc.page
    title="Dot Product Calculator - SolveKit"
    description="Free dot product calculator: u · v = Σuᵢvᵢ with the angle between the vectors."
    lede="Find the dot product."
    about="The dot product multiplies matching components and adds: ⟨1, 2, 3⟩ · ⟨4, 5, 6⟩ = 4 + 10 + 18 = 32. It equals |u||v| cos θ, so it is 0 for perpendicular vectors."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u', 'v'], 'op' => 'dot']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is ⟨1, 2, 3⟩ · ⟨4, 5, 6⟩?', 'answer' => '32.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="u" label="Vector u" value="1, 2, 3" type="text" inputmode="text" />
        <x-calc.field name="v" label="Vector v" value="4, 5, 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Dot product u · v" />

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
            <li>u · v = Σuᵢvᵢ = |u||v| cos θ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
