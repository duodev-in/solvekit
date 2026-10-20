<x-calc.page
    title="Equation of a Plane Calculator - SolveKit"
    description="Free equation of a plane calculator: ax + by + cz = d through three points, or from a point and a normal vector."
    lede="Find the equation of a plane."
    about="A plane is fixed by a point and a normal vector n = (a, b, c): a(x − x₀) + b(y − y₀) + c(z − z₀) = 0. Through three points, the normal is the cross product of two edge vectors. (1, 0, 0), (0, 2, 0), (0, 0, 3) give 6x + 3y + 2z = 6."
    :calc="['engine' => 'mt-coord', 'tool' => 'plane', 'fields' => ['given', 'p1', 'p2', 'p3', 'normal']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What plane passes through (1, 0, 0), (0, 2, 0) and (0, 0, 3)?', 'answer' => '6x + 3y + 2z = 6.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['points' => 'Three points', 'normal' => 'A point and a normal vector']" selected="points" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="p1" label="Point P₁" value="1, 0, 0" type="text" inputmode="text" />
        <div data-show-when="given:points" hidden>
            <x-calc.field name="p2" label="Point P₂" value="0, 2, 0" type="text" inputmode="text" />
        </div>
        <div data-show-when="given:points" hidden>
            <x-calc.field name="p3" label="Point P₃" value="0, 0, 3" type="text" inputmode="text" />
        </div>
    </div>

    <div data-show-when="given:normal" hidden>
        <x-calc.field name="normal" label="Normal vector n" value="2, -1, 3" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Equation of the plane" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'points', 'p1' => '1, 0, 0', 'p2' => '0, 2, 0', 'p3' => '0, 0, 3', 'normal' => '2, -1, 3'],
        'Normal' => ['given' => 'normal', 'p1' => '1, 2, 3', 'p2' => '0, 2, 0', 'p3' => '0, 0, 3', 'normal' => '2, -1, 3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'equation' => ['label' => 'Equation'],
            'normal' => ['label' => 'Normal'],
            'intercepts' => ['label' => 'Intercepts'],
            'origin' => ['label' => 'Distance from the origin'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n · (r − P) = 0</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
