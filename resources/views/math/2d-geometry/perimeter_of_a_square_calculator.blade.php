<x-calc.page
    title="Perimeter of a Square Calculator - SolveKit"
    description="Free perimeter of a square calculator: P = 4a from the side, area or diagonal."
    lede="Find the perimeter of a square."
    about="The perimeter of a square is four times its side: P = 4a. From the area, P = 4√A."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'a', 'diag', 'perim', 'area', 'circr'], 'shape' => 'square', 'want' => 'perim']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the perimeter of a square with side 6?', 'answer' => '24 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['a' => 'Side a', 'diag' => 'Diagonal d', 'perim' => 'Perimeter P', 'area' => 'Area A', 'circr' => 'Circumscribed circle radius']" selected="a" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Side a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:diag" hidden>
            <x-calc.field name="diag" label="Diagonal d" value="8.48528" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:perim" hidden>
            <x-calc.field name="perim" label="Perimeter P" value="24" min="0" step="any" />
        </div>
        <div data-show-when="given:area" hidden>
            <x-calc.field name="area" label="Area A (unit²)" value="36" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circr" hidden>
            <x-calc.field name="circr" label="Circumscribed circle radius" value="4.24264" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Perimeter P" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'a', 'unit' => 'cm', 'a' => 6, 'diag' => 8.48528, 'perim' => 24, 'area' => 36, 'circr' => 4.24264],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Side a'],
            'diag' => ['label' => 'Diagonal d'],
            'perim' => ['label' => 'Perimeter P'],
            'area' => ['label' => 'Area A'],
            'inr' => ['label' => 'Inscribed circle radius'],
            'circr' => ['label' => 'Circumscribed circle radius'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = 4a = 4√A</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
