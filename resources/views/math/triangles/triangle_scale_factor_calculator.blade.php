<x-calc.page
    title="Triangle Scale Factor Calculator - SolveKit"
    description="Free triangle scale factor calculator: k from a pair of matching sides, the scaled sides, and the area ratio k²."
    lede="Find the scale factor between triangles."
    about="The scale factor is the ratio of matching sides, k = new ÷ old. Perimeters scale by k and areas by k²: doubling the sides quadruples the area."
    :calc="['engine' => 'mt-tri', 'tool' => 'similar', 'fields' => ['mode', 'a1', 'b1', 'c1', 'match', 'side2', 'a2', 'b2', 'c2', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'A side of 3 becomes 9. What is the scale factor?', 'answer' => '3.'],
    ]"
>
    <x-calc.select name="mode" label="I want to" :options="['solve' => 'Scale a triangle (find the matching sides)', 'check' => 'Check two triangles for similarity']" selected="solve" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a1" label="Triangle 1: side a" value="3" min="0" step="any" />
        <x-calc.field name="b1" label="Side b" value="4" min="0" step="any" />
        <x-calc.field name="c1" label="Side c" value="5" min="0" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:solve" hidden>
            <x-calc.select name="match" label="I know" :options="['a' => 'The side matching a', 'b' => 'The side matching b', 'c' => 'The side matching c', 'k' => 'The scale factor']" selected="a" />
        </div>
        <div data-show-when="mode:solve" hidden>
            <x-calc.field name="side2" label="Its value" value="9" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:check" hidden>
            <x-calc.field name="a2" label="Triangle 2: side a′" value="6" min="0" step="any" />
        </div>
        <div data-show-when="mode:check" hidden>
            <x-calc.field name="b2" label="Side b′" value="8" min="0" step="any" />
        </div>
        <div data-show-when="mode:check" hidden>
            <x-calc.field name="c2" label="Side c′" value="10" min="0" step="any" />
        </div>
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />

    <x-calc.result label="Scale factor k" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'solve', 'a1' => 3, 'b1' => 4, 'c1' => 5, 'match' => 'a', 'side2' => 9, 'a2' => 6, 'b2' => 8, 'c2' => 10, 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'Scale factor'],
            'ratio' => ['label' => 'Side ratios'],
            'area' => ['label' => 'Areas'],
            'sides' => ['label' => 'Sides'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>k = new ÷ old</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
