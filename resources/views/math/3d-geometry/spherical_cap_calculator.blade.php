<x-calc.page
    title="Spherical Cap Calculator - SolveKit"
    description="Free spherical cap calculator: volume, curved and total surface area and base radius of a cap cut from a sphere."
    lede="Solve a spherical cap."
    about="A spherical cap is the part of a sphere above a cutting plane. With sphere radius r and cap height h: base radius a = √(h(2r − h)), volume πh²(3r − h)/3 and curved area 2πrh. Also known as spherical segment calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['given', 'unit', 'r', 'h', 'a'], 'shape' => 'cap', 'want' => 'vol']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a cap 2 tall from a sphere of radius 5?', 'answer' => '54.45427266 cm³.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="I know" :options="['r_h' => 'Sphere radius r and cap height h', 'a_h' => 'Base radius a and cap height h', 'r_a' => 'Sphere radius r and base radius a']" selected="r_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:r_h,r_a" hidden>
            <x-calc.field name="r" label="Sphere radius r" value="5" min="0" step="any" />
        </div>
        <div data-show-when="given:r_h,a_h" hidden>
            <x-calc.field name="h" label="Cap height h" value="2" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_h,r_a" hidden>
            <x-calc.field name="a" label="Base radius a" value="4" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'r_h', 'unit' => 'cm', 'r' => 5, 'h' => 2, 'a' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Sphere radius r'],
            'h' => ['label' => 'Cap height h'],
            'a' => ['label' => 'Base radius a'],
            'vol' => ['label' => 'Volume V'],
            'curved' => ['label' => 'Curved surface area'],
            'base' => ['label' => 'Base area'],
            'surf' => ['label' => 'Total surface area'],
            'areas' => ['label' => 'Surface area in other units'],
            'volumes' => ['label' => 'Volume in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V = πh²(3r − h) ÷ 3</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
