<x-calc.page
    title="Vector Projection Calculator - SolveKit"
    description="Free vector projection calculator: the projection of u onto v, (u · v ÷ |v|²) v, and the perpendicular component."
    lede="Project one vector onto another."
    about="The projection of u onto v is the shadow of u along v: (u · v ÷ |v|²) v. What is left, u − proj, is perpendicular to v."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u', 'v'], 'op' => 'projection']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the projection of ⟨3, 4⟩ onto ⟨1, 0⟩?', 'answer' => '⟨3, 0⟩.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="u" label="Vector u" value="3, 4" type="text" inputmode="text" />
        <x-calc.field name="v" label="Vector v" value="1, 0" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Projection of u onto v" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '3, 4', 'v' => '1, 0', 'w' => '0, 0, 3', 'k' => '1'],
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
            <li>proj_v u = (u · v ÷ |v|²) v</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
