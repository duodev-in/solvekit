<x-calc.page
    title="Exponential Function Calculator - SolveKit"
    description="Free exponential function calculator: find f(x) = a·bˣ through two points, with growth or decay rate and a graph."
    lede="Find an exponential function from two points."
    about="An exponential function f(x) = a·bˣ changes by the same factor b for each step in x. Two points fix it: b = (y₂/y₁)^(1/(x₂ − x₁)) and a = y₁/b^x₁. The equivalent continuous form is a·e^(kx) with k = ln b."
    :calc="['engine' => 'mt-explog', 'tool' => 'exp_function', 'fields' => ['x1', 'y1', 'x2', 'y2']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Which exponential passes through (0, 5) and (3, 40)?', 'answer' => 'f(x) = 5 × 2ˣ.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x1" label="x₁" value="0" step="any" />
        <x-calc.field name="y1" label="y₁" value="5" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="x2" label="x₂" value="3" step="any" />
        <x-calc.field name="y2" label="y₂" value="40" step="any" />
    </div>

    <x-calc.result label="Function" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['x1' => 0, 'y1' => 5, 'x2' => 3, 'y2' => 40],
        'Decay' => ['x1' => 1, 'y1' => 80, 'x2' => 4, 'y2' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Initial value a'],
            'b' => ['label' => 'Factor b'],
            'k' => ['label' => 'Continuous rate k'],
            'double' => ['label' => 'Doubling or half-life'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f(x) = a·bˣ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
