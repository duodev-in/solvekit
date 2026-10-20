<x-calc.page
    title="Vector Calculator - SolveKit"
    description="Free vector calculator: addition, subtraction, dot and cross products, angle, projection, magnitude, unit vector and triple product, exact with fractions."
    lede="Calculate with vectors."
    about="Vectors have size and direction. Add them component by component; the dot product u · v = Σuᵢvᵢ measures alignment; the cross product (3D only) is perpendicular to both. Results stay exact, with roots simplified."
    :calc="['engine' => 'mt-coord', 'tool' => 'vector', 'fields' => ['op', 'u', 'v', 'w', 'k']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is ⟨1, 2, 3⟩ + ⟨4, 5, 6⟩?', 'answer' => '⟨5, 7, 9⟩.'],
    ]"
>
    <x-calc.select name="op" label="Operation" :options="['add' => 'u + kv (addition)', 'sub' => 'u − kv (subtraction)', 'dot' => 'Dot product u · v', 'cross' => 'Cross product u × v', 'angle' => 'Angle between u and v', 'cosine' => 'Cosine similarity', 'projection' => 'Projection of u onto v', 'magnitude' => 'Magnitude |u|', 'unit' => 'Unit vector', 'direction' => 'Direction angles', 'triple' => 'Triple product (volume)']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="u" label="Vector u" value="1, 2, 3" type="text" inputmode="text" />
        <div data-show-when="op:add,sub,dot,cross,angle,cosine,projection,triple" hidden>
            <x-calc.field name="v" label="Vector v" value="4, 5, 6" type="text" inputmode="text" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="op:triple" hidden>
            <x-calc.field name="w" label="Vector w" value="0, 0, 3" type="text" inputmode="text" />
        </div>
        <div data-show-when="op:add,sub" hidden>
            <x-calc.field name="k" label="Multiple k of v" value="1" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['u' => '1, 2, 3', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1', 'op' => 'add'],
        'Cross' => ['u' => '1, 2, 3', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1', 'op' => 'cross'],
        'Angle' => ['u' => '1, 2, 3', 'v' => '4, 5, 6', 'w' => '0, 0, 3', 'k' => '1', 'op' => 'angle'],
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
            <li>u + v = (u₁ + v₁, …)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
