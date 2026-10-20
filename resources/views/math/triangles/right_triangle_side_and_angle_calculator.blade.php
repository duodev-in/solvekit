<x-calc.page
    title="Right Triangle Side and Angle Calculator - SolveKit"
    description="Free right triangle side and angle calculator: solve with SOH-CAH-TOA from a side and an angle, or find the angles from two sides."
    lede="Use SOH-CAH-TOA."
    about="In a right triangle sin θ = opposite/hypotenuse, cos θ = adjacent/hypotenuse and tan θ = opposite/adjacent. A 10 m ladder at 70° reaches 9.40 m up the wall, with its foot 3.42 m out. Also known as right triangle trigonometry calculator, theta calculator and trig triangle calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['mode', 'given', 'unit', 'a', 'b', 'c', 'alpha', 'area', 'perim', 'question', 'answer'], 'shape' => 'rightTriangle', 'want' => 'a', 'practice' => 'rightTriangle']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'A 10 m ladder leans at 70°. How high does it reach?', 'answer' => '9.396926208 cm.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch Mode to Practice questions for right triangle problems: Pythagoras, SOH-CAH-TOA sides and angles. Type your answer to check it and see the worked solution.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="given" label="I know" :options="['a_b' => 'Leg a and leg b', 'a_c' => 'Leg a and hypotenuse c', 'b_c' => 'Leg b and hypotenuse c', 'a_alpha' => 'Leg a and angle α (opposite a)', 'b_alpha' => 'Leg b and angle α (opposite a)', 'c_alpha' => 'Hypotenuse c and angle α (opposite a)', 'a_area' => 'Leg a and area', 'c_area' => 'Hypotenuse c and area', 'area_perim' => 'Area and perimeter']" selected="c_alpha" />
            <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:a_b,a_c,a_alpha,a_area" hidden>
                <x-calc.field name="a" label="Leg a" value="9.39693" min="0" step="any" />
            </div>
            <div data-show-when="given:a_b,b_c,b_alpha" hidden>
                <x-calc.field name="b" label="Leg b" value="3.4202" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:a_c,b_c,c_alpha,c_area" hidden>
                <x-calc.field name="c" label="Hypotenuse c" value="10" min="0" step="any" />
            </div>
            <div data-show-when="given:a_alpha,b_alpha,c_alpha" hidden>
                <x-calc.field name="alpha" label="Angle α (opposite a) (°)" value="70" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:a_area,c_area,area_perim" hidden>
                <x-calc.field name="area" label="Area (unit²)" value="16.0697" min="0" step="any" />
            </div>
            <div data-show-when="given:area_perim" hidden>
                <x-calc.field name="perim" label="Perimeter" value="22.8171" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Leg a" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'given' => 'c_alpha', 'unit' => 'cm', 'a' => 9.39693, 'b' => 3.4202, 'c' => 10, 'alpha' => 70, 'area' => 16.0697, 'perim' => 22.8171],
        'Practice' => ['given' => 'c_alpha', 'unit' => 'cm', 'a' => 9.39693, 'b' => 3.4202, 'c' => 10, 'alpha' => 70, 'area' => 16.0697, 'perim' => 22.8171, 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'a' => ['label' => 'Leg a'],
                'b' => ['label' => 'Leg b'],
                'c' => ['label' => 'Hypotenuse c'],
                'alpha' => ['label' => 'Angle α (opposite a)'],
                'beta' => ['label' => 'Angle β (opposite b)'],
                'area' => ['label' => 'Area'],
                'perim' => ['label' => 'Perimeter'],
                'h' => ['label' => 'Height to the hypotenuse'],
                'inr' => ['label' => 'Inradius'],
                'circr' => ['label' => 'Circumradius'],
                'areas' => ['label' => 'Area in other units'],
            ]" />
        </div>
        <div data-show-when="mode:practice" hidden>
            <x-calc.rows heading="Details" :rows="[
                'question' => ['label' => 'Question'],
                'yours' => ['label' => 'Your answer'],
                'check' => ['label' => 'Check'],
                'answer' => ['label' => 'Answer'],
            ]" />
        </div>
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>sin θ = opp ÷ hyp</li>
            <li>cos θ = adj ÷ hyp</li>
            <li>tan θ = opp ÷ adj</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
