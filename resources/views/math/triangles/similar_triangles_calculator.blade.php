<x-calc.page
    title="Similar Triangles Calculator - SolveKit"
    description="Free similar triangles calculator: scale a triangle to find matching sides, or check whether two triangles are similar (SSS) or congruent."
    lede="Work with similar triangles."
    about="Similar triangles have equal angles and proportional sides: every side is multiplied by the same scale factor k. Lengths scale by k, areas by k². Two triangles with side ratios all equal are similar (SSS); if k = 1 they are congruent. Also known as check similarity in right triangles calculator, similar right triangles calculator, solve similar triangles calculator and triangle similarity calculator."
    :calc="['engine' => 'mt-tri', 'tool' => 'similar', 'fields' => ['mode', 'a1', 'b1', 'c1', 'match', 'side2', 'a2', 'b2', 'c2', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'A 3-4-5 triangle is scaled so that 3 becomes 9. What are the other sides?', 'answer' => 'a′ = 9 cm, b′ = 12 cm, c′ = 15 cm.'],
        ['question' => 'Are 3-4-5 and 6-8-10 similar?', 'answer' => 'Similar (SSS).'],
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
        'Check' => ['mode' => 'check', 'a1' => 3, 'b1' => 4, 'c1' => 5, 'match' => 'a', 'side2' => 9, 'a2' => 6, 'b2' => 8, 'c2' => 10, 'unit' => 'cm'],
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
            <li>a′/a = b′/b = c′/c = k</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
