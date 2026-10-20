<x-calc.page
    title="Area of Crescent Calculator - SolveKit"
    description="Free area of a crescent calculator: the area left when one circle cuts into another (a lune), with the overlap and perimeter."
    lede="Find the area of a crescent."
    about="A crescent is what remains of a circle of radius R after a second circle of radius r, whose centre is d away, is removed. Its area is πR² minus the lens-shaped overlap, which has an exact formula from the circle–circle intersection. Also known as lune calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'crescent', 'fields' => ['outer', 'inner', 'dist', 'unit']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What area is left when a circle of radius 4 cuts into one of radius 5 with centres 3 apart?', 'answer' => '42.22469466 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="outer" label="Radius of the circle R" value="5" min="0" step="any" />
        <x-calc.field name="inner" label="Radius of the cut-out circle r" value="4" min="0" step="any" />
        <x-calc.field name="dist" label="Distance between centres d" value="3" min="0" step="any" />
    </div>

    <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />

    <x-calc.result label="Crescent area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['outer' => 5, 'inner' => 4, 'dist' => 3, 'unit' => 'cm'],
        'Thin' => ['outer' => 5, 'inner' => 5, 'dist' => 2, 'unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'lens' => ['label' => 'Overlap (lens) area'],
            'circle' => ['label' => 'Full circle'],
            'perim' => ['label' => 'Crescent perimeter'],
            'share' => ['label' => 'Share left'],
            'areas' => ['label' => 'In other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = πR² − lens</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
