<x-calc.page
    title="Area Calculator - SolveKit"
    description="Free area calculator for 14 shapes: square, rectangle, triangle, parallelogram, trapezoid, rhombus, kite, circle, ellipse, sector, regular polygon and ring, in any unit."
    lede="Find the area of a shape."
    about="Area is the amount of flat surface a shape covers, measured in square units. Choose the shape, enter its measurements in one unit, and the area is shown in that unit squared and converted to m², ft², cm² and in² (and acres for large areas). Also known as area of shapes calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'hub', 'fields' => ['fig', 'unit', 'a', 'b', 'c', 'h', 'l', 'w', 'r', 'outer', 'd1', 'd2', 'n', 'theta'], 'measure' => 'area']"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'The fields change to the measurements that shape needs.'],
        ['name' => 'Enter the measurements', 'text' => 'All in the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a circle with radius 3 cm?', 'answer' => '28.27433388 cm².'],
        ['question' => 'And a trapezoid with bases 6 and 4 and height 5?', 'answer' => '25 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fig" label="Shape" :options="['square' => 'Square (side a)', 'rectangle' => 'Rectangle (length l, width w)', 'triangle' => 'Triangle (base b, height h)', 'triangle3' => 'Triangle (three sides a, b, c)', 'parallelogram' => 'Parallelogram (base b, height h, side a)', 'trapezoid' => 'Trapezoid (bases a and b, height h)', 'rhombus' => 'Rhombus (diagonals d₁, d₂)', 'kite' => 'Kite (diagonals d₁, d₂)', 'circle' => 'Circle (radius r)', 'ellipse' => 'Ellipse (semi-axes a, b)', 'sector' => 'Sector (radius r, angle θ)', 'polygon' => 'Regular polygon (n sides of length a)', 'annulus' => 'Ring (outer radius R, inner r)']" selected="circle" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:square,triangle3,parallelogram,trapezoid,ellipse,polygon" hidden>
            <x-calc.field name="a" label="a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="fig:triangle,triangle3,parallelogram,trapezoid,ellipse" hidden>
            <x-calc.field name="b" label="b" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:triangle3" hidden>
            <x-calc.field name="c" label="c" value="5" min="0" step="any" />
        </div>
        <div data-show-when="fig:triangle,parallelogram,trapezoid" hidden>
            <x-calc.field name="h" label="Height h" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:rectangle" hidden>
            <x-calc.field name="l" label="Length l" value="8" min="0" step="any" />
        </div>
        <div data-show-when="fig:rectangle" hidden>
            <x-calc.field name="w" label="Width w" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:circle,sector,annulus" hidden>
            <x-calc.field name="r" label="Radius r" value="3" min="0" step="any" />
        </div>
        <div data-show-when="fig:annulus" hidden>
            <x-calc.field name="outer" label="Radius R" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:rhombus,kite" hidden>
            <x-calc.field name="d1" label="Diagonal d₁" value="6" min="0" step="any" />
        </div>
        <div data-show-when="fig:rhombus,kite" hidden>
            <x-calc.field name="d2" label="Diagonal d₂" value="8" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:polygon" hidden>
            <x-calc.field name="n" label="Number of sides n" value="6" min="0" step="1" />
        </div>
        <div data-show-when="fig:sector" hidden>
            <x-calc.field name="theta" label="Angle θ (°)" value="60" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fig' => 'circle', 'unit' => 'cm', 'r' => 3],
        'Trapezoid' => ['fig' => 'trapezoid', 'unit' => 'cm', 'a' => 6, 'b' => 4, 'h' => 5],
        'Triangle' => ['fig' => 'triangle', 'unit' => 'm', 'b' => 6, 'h' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
            'given' => ['label' => 'Values used'],
            'areas' => ['label' => 'In other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = πr², A = lw, A = bh/2, …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
