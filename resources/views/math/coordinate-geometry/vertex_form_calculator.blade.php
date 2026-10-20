<x-calc.page
    title="Vertex Form Calculator - SolveKit"
    description="Free vertex form calculator: convert y = ax² + bx + c to y = a(x − h)² + k (and back) by completing the square."
    lede="Convert to vertex form."
    about="Vertex form a(x − h)² + k shows the vertex (h, k) directly. Complete the square: x² − 4x + 3 = (x − 2)² − 1, so the vertex is (2, −1)."
    :calc="['engine' => 'mt-coord', 'tool' => 'parabola', 'fields' => ['given', 'a', 'b', 'c', 'h', 'k', 'fx', 'fy', 'dy'], 'want' => 'vertexForm']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Write y = x² − 4x + 3 in vertex form.', 'answer' => 'y = (x − 2)² − 1.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['standard' => 'Standard form y = ax² + bx + c', 'vertex' => 'Vertex form y = a(x − h)² + k', 'focus' => 'Focus and directrix']" selected="standard" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:standard,vertex" hidden>
            <x-calc.field name="a" label="a" value="1" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:standard" hidden>
            <x-calc.field name="b" label="b" value="-4" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:standard" hidden>
            <x-calc.field name="c" label="c" value="3" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:vertex" hidden>
            <x-calc.field name="h" label="h" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:vertex" hidden>
            <x-calc.field name="k" label="k" value="-1" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="given:focus" hidden>
            <x-calc.field name="fx" label="Focus x" value="0" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:focus" hidden>
            <x-calc.field name="fy" label="Focus y" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:focus" hidden>
            <x-calc.field name="dy" label="Directrix y =" value="-2" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Vertex form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'standard', 'a' => '1', 'b' => '-4', 'c' => '3', 'h' => '2', 'k' => '-1', 'fx' => '0', 'fy' => '2', 'dy' => '-2'],
        'Back' => ['given' => 'vertex', 'a' => '2', 'b' => '-4', 'c' => '3', 'h' => '-1', 'k' => '5', 'fx' => '0', 'fy' => '2', 'dy' => '-2'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'vertex' => ['label' => 'Vertex'],
            'standard' => ['label' => 'Standard form'],
            'vertexForm' => ['label' => 'Vertex form'],
            'focus' => ['label' => 'Focus'],
            'directrix' => ['label' => 'Directrix'],
            'axis' => ['label' => 'Axis of symmetry'],
            'roots' => ['label' => 'x-intercepts'],
            'yint' => ['label' => 'y-intercept'],
            'latus' => ['label' => 'Latus rectum'],
            'opens' => ['label' => 'Opens'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>h = −b/2a, k = c − b²/4a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
