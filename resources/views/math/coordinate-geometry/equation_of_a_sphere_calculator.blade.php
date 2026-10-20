<x-calc.page
    title="Equation of a Sphere Calculator - SolveKit"
    description="Free equation of a sphere calculator: standard and general form from the centre and radius, or the centre and radius from an equation."
    lede="Find the equation of a sphere."
    about="A sphere with centre (h, k, l) and radius r is (x − h)² + (y − k)² + (z − l)² = r². Completing the square turns x² + y² + z² − 2x + 4y − 6z = 2 into centre (1, −2, 3), radius 4."
    :calc="['engine' => 'mt-coord', 'tool' => 'sphere_eq', 'fields' => ['given', 'h', 'k', 'l', 'r', 'eq']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What is the sphere with centre (1, −2, 3) and radius 4?', 'answer' => '(x − 1)² + (y + 2)² + (z − 3)² = 16.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['center' => 'The centre and radius', 'general' => 'The general equation']" selected="center" />

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div data-show-when="given:center" hidden>
            <x-calc.field name="h" label="h" value="1" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:center" hidden>
            <x-calc.field name="k" label="k" value="-2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:center" hidden>
            <x-calc.field name="l" label="l" value="3" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:center" hidden>
            <x-calc.field name="r" label="r" value="4" type="text" inputmode="decimal" />
        </div>
    </div>

    <div data-show-when="given:general" hidden>
        <x-calc.field name="eq" label="Equation" value="x^2 + y^2 + z^2 - 2x + 4y - 6z = 2" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Standard equation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'center', 'h' => '1', 'k' => '-2', 'l' => '3', 'r' => '4', 'eq' => 'x^2 + y^2 + z^2 - 2x + 4y - 6z = 2'],
        'General' => ['given' => 'general', 'h' => '1', 'k' => '-2', 'l' => '3', 'r' => '4', 'eq' => 'x^2 + y^2 + z^2 - 2x + 4y - 6z = 2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'standard' => ['label' => 'Standard form'],
            'general' => ['label' => 'General form'],
            'center' => ['label' => 'Centre'],
            'radius' => ['label' => 'Radius'],
            'volume' => ['label' => 'Volume and area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(x − h)² + (y − k)² + (z − l)² = r²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
