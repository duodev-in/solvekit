<x-calc.page
    title="Equilateral Triangle Calculator - SolveKit"
    description="Free equilateral triangle calculator: area, height, perimeter, inradius and circumradius from any one measure."
    lede="Solve an equilateral triangle."
    about="All three sides of an equilateral triangle are equal and every angle is 60°. Its height is (√3/2)a and its area (√3/4)a²: side 6 gives height 5.196 and area 15.59. Also known as equilateral triangle area calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'h', 'area', 'perim', 'inr', 'circr'], 'shape' => 'equilateral', 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of an equilateral triangle with side 6?', 'answer' => '15.58845727 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Side a', 'h' => 'Height h', 'area' => 'Area A', 'perim' => 'Perimeter P', 'inr' => 'Inradius r', 'circr' => 'Circumradius R']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Side a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:h" hidden>
            <x-calc.field name="h" label="Height h" value="5.19615" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="15.5885" min="0" step="any" />
        </div>
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="18" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:inr" hidden>
            <x-calc.field name="inr" label="Inradius r" value="1.73205" min="0" step="any" />
        </div>
        <div data-show-when="given:circr" hidden>
            <x-calc.field name="circr" label="Circumradius R" value="3.4641" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a', 'unit' => 'cm', 'a' => 6, 'h' => 5.19615, 'area' => 15.5885, 'perim' => 18, 'inr' => 1.73205, 'circr' => 3.4641],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Side a'],
            'h' => ['label' => 'Height h'],
            'area' => ['label' => 'Area A'],
            'perim' => ['label' => 'Perimeter P'],
            'inr' => ['label' => 'Inradius r'],
            'circr' => ['label' => 'Circumradius R'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = (√3/4)a²</li>
            <li>h = (√3/2)a</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
