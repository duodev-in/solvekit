<x-calc.page
    title="Unit Vector Calculator - SolveKit"
    description="Free unit vector calculator: û = u ÷ |u|, exact with roots."
    lede="Normalise a vector."
    about="A unit vector has length 1 and points the same way: ⟨3, 4⟩ ÷ 5 = ⟨3/5, 4/5⟩. Normalising keeps direction and discards size."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u'], 'op' => 'unit']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the unit vector of ⟨3, 4⟩?', 'answer' => '⟨3/5, 4/5⟩.'],
    ]"
>
    <x-calc.field name="u" label="Vector u" value="3, 4" type="text" inputmode="text" />

    <x-calc.result label="Unit vector" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '3, 4', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1'],
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
            <li>û = u ÷ |u|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
