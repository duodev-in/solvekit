<x-calc.page
    title="Cosine Similarity Calculator - SolveKit"
    description="Free cosine similarity calculator: cos θ = u · v ÷ (|u||v|) for vectors of any length, exact as a root."
    lede="Measure cosine similarity."
    about="Cosine similarity compares directions, ignoring length: 1 means the same direction, 0 unrelated (perpendicular), −1 opposite. It is widely used to compare documents and embeddings."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u', 'v'], 'op' => 'cosine']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'How similar are ⟨1, 2, 3⟩ and ⟨4, 5, 6⟩?', 'answer' => '16√22/77.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="u" label="Vector u" value="1, 2, 3" type="text" inputmode="text" />
        <x-calc.field name="v" label="Vector v" value="4, 5, 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Cosine similarity" />

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
            <li>cos θ = u · v ÷ (|u||v|)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
