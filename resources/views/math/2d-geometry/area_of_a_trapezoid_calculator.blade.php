<x-calc.page
    title="Area of a Trapezoid Calculator - SolveKit"
    description="Free area of a trapezoid calculator: A = (a + b)h ÷ 2, or the height from the area."
    lede="Find the area of a trapezoid."
    about="The area is the midsegment (a + b)/2 times the height. A trapezoid with bases 10 and 6 and height 4 has area 8 × 4 = 32."
    :calc="['engine' => 'mt-shape', 'tool' => 'trapezoid', 'fields' => ['kind', 'given', 'unit', 'a', 'b', 'h', 'c', 'd', 'alpha', 'area', 'm'], 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a trapezoid with bases 10 and 6 and height 4?', 'answer' => '32 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="kind" label="Trapezoid" :options="['isosceles' => 'Isosceles', 'right' => 'Right', 'general' => 'General']" selected="isosceles" />
        <x-calc.select name="given" label="I know" :options="['a_b_h' => 'Both bases and the height', 'a_b_c_d' => 'All four sides', 'a_b_alpha' => 'Both bases and a base angle', 'a_b_area' => 'Both bases and the area', 'm_h' => 'Midsegment and height']" selected="a_b_h" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h,a_b_c_d,a_b_alpha,a_b_area">
            <x-calc.field name="a" label="Long base a" value="10" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_h,a_b_c_d,a_b_alpha,a_b_area">
            <x-calc.field name="b" label="Short base b" value="6" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_h,m_h">
            <x-calc.field name="h" label="Height h" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_c_d" hidden>
            <x-calc.field name="c" label="Left leg c" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_c_d" hidden>
            <x-calc.field name="d" label="Right leg d" value="4.5" min="0" step="any" />
        </div>
        <div data-show-when="given:a_b_alpha" hidden>
            <x-calc.field name="alpha" label="Base angle at the long base (°)" value="60" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:a_b_area" hidden>
            <x-calc.field name="area" label="Area (unit²)" value="32" min="0" step="any" />
        </div>
        <div data-show-when="given:m_h" hidden>
            <x-calc.field name="m" label="Midsegment m" value="8" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['kind' => 'isosceles', 'given' => 'a_b_h', 'unit' => 'cm', 'a' => 10, 'b' => 6, 'h' => 4, 'c' => 5, 'd' => 4.5, 'alpha' => 60, 'area' => 32, 'm' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Area'],
            'h' => ['label' => 'Height'],
            'm' => ['label' => 'Midsegment'],
            'perim' => ['label' => 'Perimeter'],
            'legs' => ['label' => 'Legs'],
            'angles' => ['label' => 'Angles'],
            'diagonals' => ['label' => 'Diagonals'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = (a + b) h ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
