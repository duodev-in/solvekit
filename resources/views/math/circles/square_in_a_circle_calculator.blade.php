<x-calc.page
    title="Square in a Circle Calculator - SolveKit"
    description="Free square in a circle calculator: the largest square inside a circle, its side, area and the leftover area."
    lede="Fit a square in a circle."
    about="The biggest square inside a circle has the circle's diameter as its diagonal, so its side is r√2 and its area 2r², about 63.66% of the circle. Going the other way, a square of side a needs a circle of radius a/√2."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'a', 'circleArea', 'squareArea'], 'shape' => 'squareInCircle', 'want' => 'a']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the largest square that fits in a circle of radius 5?', 'answer' => 'Side 7.071067812 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r' => 'Circle radius', 'a' => 'Square side', 'circleArea' => 'Circle area', 'squareArea' => 'Square area']" selected="r" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r" hidden>
            <x-calc.field name="r" label="Circle radius" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Square side" value="7.07107" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:circleArea" hidden>
            <x-calc.field name="circleArea" label="Circle area (unit²)" value="78.5398" min="0" step="any" />
        </div>
        <div data-show-when="given:squareArea" hidden>
            <x-calc.field name="squareArea" label="Square area (unit²)" value="50" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Square side" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r', 'unit' => 'cm', 'r' => 5, 'a' => 7.07107, 'circleArea' => 78.5398, 'squareArea' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Circle radius'],
            'a' => ['label' => 'Square side'],
            'circleArea' => ['label' => 'Circle area'],
            'squareArea' => ['label' => 'Square area'],
            'leftover' => ['label' => 'Area outside the square'],
            'share' => ['label' => 'Square share of the circle (%)'],
            'areas' => ['label' => 'Surface area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a = r√2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
