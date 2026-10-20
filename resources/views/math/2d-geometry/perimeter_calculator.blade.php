<x-calc.page
    title="Perimeter Calculator - SolveKit"
    description="Free perimeter calculator: the distance around a square, rectangle, triangle, parallelogram, trapezoid, rhombus, circle, ellipse, sector or regular polygon."
    lede="Find the perimeter of a shape."
    about="The perimeter is the total length of the boundary. For polygons add the sides; for a circle it is the circumference 2πr; an ellipse uses the exact elliptic-integral formula."
    :calc="['engine' => 'mt-shape', 'tool' => 'hub', 'fields' => ['fig', 'unit', 'a', 'b', 'c', 'd', 'h', 'l', 'w', 'r', 'd1', 'd2', 'n', 'theta'], 'measure' => 'perim']"
    :how-to="[
        ['name' => 'Choose the shape', 'text' => 'The fields change to the measurements that shape needs.'],
        ['name' => 'Enter the measurements', 'text' => 'All in the same unit.'],
    ]"
    :faqs="[
        ['question' => 'What is the perimeter of an 8 × 5 rectangle?', 'answer' => '26 cm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fig" label="Shape" :options="['square' => 'Square (side a)', 'rectangle' => 'Rectangle (length l, width w)', 'triangle3' => 'Triangle (three sides a, b, c)', 'parallelogram' => 'Parallelogram (base b, height h, side a)', 'trapezoid4' => 'Trapezoid (four sides a, b, c, d)', 'rhombus' => 'Rhombus (diagonals d₁, d₂)', 'circle' => 'Circle (radius r)', 'ellipse' => 'Ellipse (semi-axes a, b)', 'sector' => 'Sector (radius r, angle θ)', 'polygon' => 'Regular polygon (n sides of length a)']" selected="rectangle" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:square,triangle3,parallelogram,trapezoid4,ellipse,polygon" hidden>
            <x-calc.field name="a" label="a" value="6" min="0" step="any" />
        </div>
        <div data-show-when="fig:triangle3,parallelogram,trapezoid4,ellipse" hidden>
            <x-calc.field name="b" label="b" value="4" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:triangle3,trapezoid4" hidden>
            <x-calc.field name="c" label="c" value="5" min="0" step="any" />
        </div>
        <div data-show-when="fig:trapezoid4" hidden>
            <x-calc.field name="d" label="d" value="4.5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:parallelogram" hidden>
            <x-calc.field name="h" label="Height h" value="5" min="0" step="any" />
        </div>
        <div data-show-when="fig:rectangle" hidden>
            <x-calc.field name="l" label="Length l" value="8" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:rectangle" hidden>
            <x-calc.field name="w" label="Width w" value="5" min="0" step="any" />
        </div>
        <div data-show-when="fig:circle,sector" hidden>
            <x-calc.field name="r" label="Radius r" value="3" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="fig:rhombus" hidden>
            <x-calc.field name="d1" label="Diagonal d₁" value="6" min="0" step="any" />
        </div>
        <div data-show-when="fig:rhombus" hidden>
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

    <x-calc.result label="Perimeter" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fig' => 'rectangle', 'unit' => 'cm', 'l' => 8, 'w' => 5],
        'Circle' => ['fig' => 'circle', 'unit' => 'cm', 'r' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
            'given' => ['label' => 'Values used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = sum of the sides</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
