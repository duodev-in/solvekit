<x-calc.page
    title="Area of a Rectangle Calculator - SolveKit"
    description="Free area of a rectangle calculator: length × width in any unit, or solve the length, width, diagonal or perimeter from what you know."
    lede="Find the area of a rectangle."
    about="The area of a rectangle is length × width: a room 8 m by 5 m has 40 m². You can also start from the area and one side, the perimeter, the diagonal or the aspect ratio, and every other measure follows."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['mode', 'given', 'unit', 'l', 'w', 'diag', 'perim', 'area', 'ratio', 'angle', 'question', 'answer'], 'shape' => 'rectangle', 'want' => 'area', 'practice' => 'rectangle']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the area of an 8 cm × 5 cm rectangle?', 'answer' => '40 cm².'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch Mode to Practice questions: each question number gives a rectangle problem (area, perimeter, a missing side or the diagonal). Type your answer to see whether it is right, with the worked solution.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="given" label="I know" :options="['l_w' => 'Length l and width w', 'l_area' => 'Length l and area A', 'w_area' => 'Width w and area A', 'l_perim' => 'Length l and perimeter P', 'w_perim' => 'Width w and perimeter P', 'l_diag' => 'Length l and diagonal d', 'area_perim' => 'Area A and perimeter P', 'diag_perim' => 'Diagonal d and perimeter P', 'area_ratio' => 'Area A and aspect ratio l : w', 'perim_ratio' => 'Perimeter P and aspect ratio l : w', 'diag_ratio' => 'Diagonal d and aspect ratio l : w', 'diag_angle' => 'Diagonal d and angle between diagonal and length']" selected="l_w" />
            <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:l_w,l_area,l_perim,l_diag" hidden>
                <x-calc.field name="l" label="Length l" value="8" min="0" step="any" />
            </div>
            <div data-show-when="given:l_w,w_area,w_perim" hidden>
                <x-calc.field name="w" label="Width w" value="5" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:l_diag,diag_perim,diag_ratio,diag_angle" hidden>
                <x-calc.field name="diag" label="Diagonal d" value="9.43398" min="0" step="any" />
            </div>
            <div data-show-when="given:l_perim,w_perim,area_perim,diag_perim,perim_ratio" hidden>
                <x-calc.field name="perim" label="Perimeter P" value="26" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:l_area,w_area,area_perim,area_ratio" hidden>
                <x-calc.field name="area" label="Area A (unit²)" value="40" min="0" step="any" />
            </div>
            <div data-show-when="given:area_ratio,perim_ratio,diag_ratio" hidden>
                <x-calc.field name="ratio" label="Aspect ratio l : w" value="1.6" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:diag_angle" hidden>
                <x-calc.field name="angle" label="Angle between diagonal and length (°)" value="32.0054" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Area A" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'given' => 'l_w', 'unit' => 'cm', 'l' => 8, 'w' => 5, 'diag' => 9.43398, 'perim' => 26, 'area' => 40, 'ratio' => 1.6, 'angle' => 32.0054],
        'Practice' => ['given' => 'l_w', 'unit' => 'cm', 'l' => 8, 'w' => 5, 'diag' => 9.43398, 'perim' => 26, 'area' => 40, 'ratio' => 1.6, 'angle' => 32.0054, 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'l' => ['label' => 'Length l'],
                'w' => ['label' => 'Width w'],
                'diag' => ['label' => 'Diagonal d'],
                'perim' => ['label' => 'Perimeter P'],
                'area' => ['label' => 'Area A'],
                'ratio' => ['label' => 'Aspect ratio l : w'],
                'angle' => ['label' => 'Angle between diagonal and length'],
                'circr' => ['label' => 'Circumscribed circle radius'],
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
            <li>A = l × w</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
