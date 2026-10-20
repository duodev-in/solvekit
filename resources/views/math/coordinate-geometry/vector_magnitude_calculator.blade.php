<x-calc.page
    title="Vector Magnitude Calculator - SolveKit"
    description="Free vector magnitude calculator: |u| = √(u₁² + u₂² + …) as a simplified root."
    lede="Find the length of a vector."
    about="The magnitude (length, norm) of a vector is √ of the sum of its squared components: |⟨2, 3, 6⟩| = √49 = 7. Also known as vector length calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u'], 'op' => 'magnitude']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the length of ⟨2, 3, 6⟩?', 'answer' => '7.'],
    ]"
>
    <x-calc.field name="u" label="Vector u" value="2, 3, 6" type="text" inputmode="text" />

    <x-calc.result label="Magnitude |u|" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '2, 3, 6', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1'],
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
            <li>|u| = √Σuᵢ²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
