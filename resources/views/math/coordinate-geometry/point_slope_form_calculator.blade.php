<x-calc.page
    title="Point Slope Form Calculator - SolveKit"
    description="Free point-slope form calculator: y − y₁ = m(x − x₁) from a point and slope or two points, with the other forms."
    lede="Write a line in point-slope form."
    about="Point-slope form y − y₁ = m(x − x₁) uses one point and the slope directly. Through (2, −3) with slope 1/2: y + 3 = (1/2)(x − 2), which is y = (1/2)x − 4."
    :calc="['engine' => 'mt-coord', 'tool' => 'line', 'fields' => ['given', 'x1', 'y1', 'x2', 'y2', 'm', 'b'], 'want' => 'pointSlope']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Write the line through (2, −3) with slope 1/2.', 'answer' => 'y + 3 = (1/2)(x − 2).'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['point_slope' => 'A point and the slope', 'points' => 'Two points']" selected="point_slope" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points,point_slope">
            <x-calc.field name="x1" label="x₁" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:points,point_slope">
            <x-calc.field name="y1" label="y₁" value="-3" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points" hidden>
            <x-calc.field name="x2" label="x₂" value="4" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:points" hidden>
            <x-calc.field name="y2" label="y₂" value="8" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:point_slope">
            <x-calc.field name="m" label="Slope m" value="1/2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:none" hidden>
            <x-calc.field name="b" label="y-intercept b" value="-3" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Point-slope form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'point_slope', 'x1' => '2', 'y1' => '-3', 'x2' => '4', 'y2' => '8', 'm' => '1/2', 'b' => '-3', 'eq' => '2x - 3y = 6'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'slopeIntercept' => ['label' => 'Slope-intercept form'],
            'pointSlope' => ['label' => 'Point-slope form'],
            'standard' => ['label' => 'Standard form'],
            'slope' => ['label' => 'Slope'],
            'yint' => ['label' => 'y-intercept'],
            'xint' => ['label' => 'x-intercept'],
            'angle' => ['label' => 'Angle with the x-axis'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>y − y₁ = m(x − x₁)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
