<x-calc.page
    title="Triangular Pyramid Volume Calculator - SolveKit"
    description="Free triangular pyramid volume calculator: from the four vertices (scalar triple product) or from the base sides and height."
    lede="Find the volume of a triangular pyramid."
    about="Any triangular pyramid (tetrahedron) has volume ⅓ × base area × height. From coordinates, V = |AB · (AC × AD)|/6: the corner (0, 0, 0), (1, 0, 0), (0, 1, 0), (0, 0, 1) cuts off 1/6 of a unit cube."
    :calc="['engine' => 'mt-solid', 'tool' => 'tetra', 'fields' => ['given', 'unit', 'x1', 'y1', 'z1', 'x2', 'y2', 'z2', 'x3', 'y3', 'z3', 'x4', 'y4', 'z4', 'a', 'b', 'c', 'h']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of the pyramid with vertices (0, 0, 0), (4, 0, 0), (0, 3, 0) and (0, 0, 5)?', 'answer' => '10 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['vertices' => 'The four vertices', 'base' => 'The base sides and the height']" selected="vertices" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="x1" label="Vertex 1: x" value="0" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="y1" label="y" value="0" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="z1" label="z" value="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="x2" label="Vertex 2: x" value="4" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="y2" label="y" value="0" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="z2" label="z" value="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="x3" label="Vertex 3: x" value="0" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="y3" label="y" value="3" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="z3" label="z" value="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="x4" label="Vertex 4: x" value="0" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="y4" label="y" value="0" step="any" />
        </div>
        <div data-show-when="given:vertices" hidden>
            <x-calc.field name="z4" label="z" value="5" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div data-show-when="given:base" hidden>
            <x-calc.field name="a" label="Base side a" value="3" min="0" step="any" />
        </div>
        <div data-show-when="given:base" hidden>
            <x-calc.field name="b" label="Base side b" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:base" hidden>
            <x-calc.field name="c" label="Base side c" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:base" hidden>
            <x-calc.field name="h" label="Height h" value="6" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'vertices', 'unit' => 'cm', 'x1' => 0, 'y1' => 0, 'z1' => 0, 'x2' => 4, 'y2' => 0, 'z2' => 0, 'x3' => 0, 'y3' => 3, 'z3' => 0, 'x4' => 0, 'y4' => 0, 'z4' => 5, 'a' => 3, 'b' => 4, 'c' => 5, 'h' => 6],
        'Base' => ['given' => 'base', 'unit' => 'cm', 'x1' => 0, 'y1' => 0, 'z1' => 0, 'x2' => 4, 'y2' => 0, 'z2' => 0, 'x3' => 0, 'y3' => 3, 'z3' => 0, 'x4' => 0, 'y4' => 0, 'z4' => 5, 'a' => 3, 'b' => 4, 'c' => 5, 'h' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'base' => ['label' => 'Base or faces'],
            'vol' => ['label' => 'Volume'],
            'volumes' => ['label' => 'In other units'],
            'faces' => ['label' => 'Surface'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = |AB · (AC × AD)| ÷ 6</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
