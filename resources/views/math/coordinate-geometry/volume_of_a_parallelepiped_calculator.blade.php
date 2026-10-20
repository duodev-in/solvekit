<x-calc.page
    title="Volume of a Parallelepiped Calculator - SolveKit"
    description="Free parallelepiped volume calculator: |u · (v × w)|, the scalar triple product of three edge vectors."
    lede="Find the volume of a parallelepiped."
    about="Three edge vectors from one corner span a parallelepiped whose volume is the absolute scalar triple product |u · (v × w)|, the determinant of the 3 × 3 matrix of the vectors. Zero means they lie in one plane. Also known as scalar triple product calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['u', 'v', 'w'], 'op' => 'triple']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What volume do ⟨1, 0, 0⟩, ⟨0, 2, 0⟩ and ⟨0, 0, 3⟩ span?', 'answer' => '6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="u" label="Vector u" value="1, 0, 0" type="text" inputmode="text" />
        <x-calc.field name="v" label="Vector v" value="0, 2, 0" type="text" inputmode="text" />
        <x-calc.field name="w" label="Vector w" value="0, 0, 3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Triple product (volume)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '1, 0, 0', 'v' => '0, 2, 0', 'w' => '0, 0, 3', 'k' => '1'],
        'Slanted' => ['u' => '2, 1, 0', 'v' => '1, 3, 1', 'w' => '0, 1, 4', 'k' => '1'],
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
            <li>V = |u · (v × w)|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
