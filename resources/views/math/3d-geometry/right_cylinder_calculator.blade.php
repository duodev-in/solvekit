<x-calc.page
    title="Right Cylinder Calculator - SolveKit"
    description="Free right cylinder calculator: volume, lateral area, base area and total surface area, or the radius or height from the volume."
    lede="Solve a cylinder."
    about="A right circular cylinder of radius r and height h has volume πr²h, lateral area 2πrh and total area 2πr(r + h). A can 6 cm across and 10 cm tall holds 282.7 cm³. Also known as cylinder calculator."
    :calc="['engine' => 'mt-shape', 'tool' => 'shape', 'fields' => ['mode', 'given', 'unit', 'r', 'h', 'd', 'vol', 'lat', 'surf', 'circ', 'question', 'answer'], 'shape' => 'cylinder', 'want' => 'vol', 'practice' => 'cylinder']"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'What is the volume of a cylinder with radius 3 cm and height 10 cm?', 'answer' => '282.7433388 cm³.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch Mode to Practice questions for cylinder volume (in cm³ and litres) and surface area problems; type your answer to check it and see the worked solution.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="given" label="I know" :options="['r_h' => 'Radius r and height h', 'd_h' => 'Diameter and height h', 'vol_r' => 'Volume V and radius r', 'vol_h' => 'Volume V and height h', 'lat_r' => 'Lateral surface area and radius r', 'lat_h' => 'Lateral surface area and height h', 'surf_r' => 'Total surface area and radius r', 'circ_h' => 'Base circumference and height h']" selected="r_h" />
            <x-calc.select name="unit" label="Unit" :options="['mm' => 'mm', 'cm' => 'cm', 'm' => 'm', 'km' => 'km', 'in' => 'in', 'ft' => 'ft', 'yd' => 'yd', 'mi' => 'mi', 'units' => 'No unit']" selected="cm" />
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:r_h,vol_r,lat_r,surf_r" hidden>
                <x-calc.field name="r" label="Radius r" value="3" min="0" step="any" />
            </div>
            <div data-show-when="given:r_h,d_h,vol_h,lat_h,circ_h" hidden>
                <x-calc.field name="h" label="Height h" value="10" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:d_h" hidden>
                <x-calc.field name="d" label="Diameter" value="6" min="0" step="any" />
            </div>
            <div data-show-when="given:vol_r,vol_h" hidden>
                <x-calc.field name="vol" label="Volume V (unit³)" value="282.743" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:lat_r,lat_h" hidden>
                <x-calc.field name="lat" label="Lateral surface area (unit²)" value="188.496" min="0" step="any" />
            </div>
            <div data-show-when="given:surf_r" hidden>
                <x-calc.field name="surf" label="Total surface area (unit²)" value="245.044" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="given:circ_h" hidden>
                <x-calc.field name="circ" label="Base circumference" value="18.8496" min="0" step="any" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Volume V" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'given' => 'r_h', 'unit' => 'cm', 'r' => 3, 'h' => 10, 'd' => 6, 'vol' => 282.743, 'lat' => 188.496, 'surf' => 245.044, 'circ' => 18.8496],
        'Practice' => ['given' => 'r_h', 'unit' => 'cm', 'r' => 3, 'h' => 10, 'd' => 6, 'vol' => 282.743, 'lat' => 188.496, 'surf' => 245.044, 'circ' => 18.8496, 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Diagram" name="diagram" />
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'r' => ['label' => 'Radius r'],
                'h' => ['label' => 'Height h'],
                'd' => ['label' => 'Diameter'],
                'vol' => ['label' => 'Volume V'],
                'lat' => ['label' => 'Lateral surface area'],
                'base' => ['label' => 'Base area'],
                'surf' => ['label' => 'Total surface area'],
                'circ' => ['label' => 'Base circumference'],
                'diag' => ['label' => 'Longest straight line inside'],
                'areas' => ['label' => 'Surface area in other units'],
                'volumes' => ['label' => 'Volume in other units'],
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
            <li>V = πr²h</li>
            <li>A = 2πr(r + h)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
