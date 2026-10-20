<x-calc.page
    title="Rhombus Area Calculator - SolveKit"
    description="Free rhombus area calculator: A = d₁d₂ ÷ 2 from the diagonals, or a² sin θ from a side and angle."
    lede="Find the area of a rhombus."
    about="A rhombus has four equal sides and diagonals that cross at right angles, so its area is half the product of the diagonals: 6 and 8 give 24, with side 5."
    :calc="['engine' => 'mt-shape', 'tool' => 'quad', 'fields' => ['given', 'unit', 'a', 'b', 'c', 'd', 'alpha', 'gamma', 'p', 'h', 'd1', 'd2'], 'want' => 'area']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of a rhombus with diagonals 6 and 8?', 'answer' => '24 cm².'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="given" label="Shape and what you know" :options="['gen_angles' => 'Four sides and two opposite angles', 'gen_diag' => 'Four sides and a diagonal', 'para_angle' => 'Parallelogram: two sides and an angle', 'para_height' => 'Parallelogram: base, side and height', 'rhombus_angle' => 'Rhombus: side and an angle', 'rhombus_diags' => 'Rhombus: both diagonals', 'kite_diags' => 'Kite: both diagonals', 'kite_angle' => 'Kite: two sides and the angle between them']" selected="rhombus_diags" />
        <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:gen_angles,gen_diag,para_angle,para_height,rhombus_angle,kite_angle" hidden>
            <x-calc.field name="a" label="Side a" value="4" min="0" step="any" />
        </div>
        <div data-show-when="given:gen_angles,gen_diag,para_angle,para_height,kite_angle" hidden>
            <x-calc.field name="b" label="Side b" value="5" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:gen_angles,gen_diag" hidden>
            <x-calc.field name="c" label="Side c" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:gen_angles,gen_diag" hidden>
            <x-calc.field name="d" label="Side d" value="7" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:gen_angles,para_angle,rhombus_angle,kite_angle" hidden>
            <x-calc.field name="alpha" label="Angle α (°)" value="80" min="0" step="any" />
        </div>
        <div data-show-when="given:gen_angles" hidden>
            <x-calc.field name="gamma" label="Opposite angle γ (°)" value="110" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:gen_diag" hidden>
            <x-calc.field name="p" label="Diagonal p (from the a–d corner to the b–c corner)" value="8" min="0" step="any" />
        </div>
        <div data-show-when="given:para_height" hidden>
            <x-calc.field name="h" label="Height h" value="3" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:rhombus_diags,kite_diags">
            <x-calc.field name="d1" label="Diagonal d₁" value="6" min="0" step="any" />
        </div>
        <div data-show-when="given:rhombus_diags,kite_diags">
            <x-calc.field name="d2" label="Diagonal d₂" value="8" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Area" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'rhombus_diags', 'unit' => 'cm', 'a' => 4, 'b' => 5, 'c' => 6, 'd' => 7, 'alpha' => 80, 'gamma' => 110, 'p' => 8, 'h' => 3, 'd1' => 6, 'd2' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Area'],
            'perim' => ['label' => 'Perimeter'],
            'extra' => ['label' => 'Other measures'],
            'areas' => ['label' => 'Area in other units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = d₁d₂ ÷ 2</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
