<x-calc.page
    title="Golden Rectangle Calculator - SolveKit"
    description="Free golden rectangle calculator: the sides of a rectangle in the golden ratio φ ≈ 1.618 from one side, the area or a + b."
    lede="Find a golden rectangle."
    about="In a golden rectangle the long side divided by the short side is φ = (1 + √5)/2 ≈ 1.618. Cutting off a square leaves a smaller golden rectangle, which is how the golden spiral is drawn."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'long', 'short', 'sum', 'area'], 'shape' => 'golden', 'want' => 'short']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the short side of a golden rectangle 10 cm long?', 'answer' => '6.180339887 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['long' => 'Long side a', 'short' => 'Short side b', 'sum' => 'a + b', 'area' => 'Area']" selected="long" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:long" hidden>
            <x-calc.field name="long" label="Long side a" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:short" hidden>
            <x-calc.field name="short" label="Short side b" value="6.18034" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:sum" hidden>
            <x-calc.field name="sum" label="a + b" value="16.1803" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="61.8034" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Short side b" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'long', 'unit' => 'cm', 'long' => 10, 'short' => 6.18034, 'sum' => 16.1803, 'area' => 61.8034],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'long' => ['label' => 'Long side a'],
            'short' => ['label' => 'Short side b'],
            'sum' => ['label' => 'a + b'],
            'area' => ['label' => 'Area'],
            'perim' => ['label' => 'Perimeter'],
            'diag' => ['label' => 'Diagonal'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a ÷ b = φ = (1 + √5) ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
