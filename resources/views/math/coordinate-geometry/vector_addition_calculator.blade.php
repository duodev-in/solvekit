<x-calc.page
    title="Vector Addition Calculator - SolveKit"
    description="Free vector addition calculator: u + v, u − v and u + kv, component by component."
    lede="Add vectors."
    about="Vectors add tip to tail: (3, 4) + (1, −2) = (4, 2). Subtraction adds the opposite vector, and kv scales v first."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u', 'v', 'k'], 'op' => 'add']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is ⟨3, 4⟩ + ⟨1, −2⟩?', 'answer' => '⟨4, 2⟩.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="u" label="Vector u" value="3, 4" type="text" inputmode="text" />
        <x-calc.field name="v" label="Vector v" value="1, -2" type="text" inputmode="text" />
        <x-calc.field name="k" label="Multiple k of v" value="1" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="u + kv (addition)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '3, 4', 'v' => '1, -2', 'w' => '0, 0, 3', 'k' => '1'],
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
            <li>u + v = (u₁ + v₁, u₂ + v₂)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
