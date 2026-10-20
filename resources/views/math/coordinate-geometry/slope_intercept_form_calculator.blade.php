<x-calc.page
    title="Slope Intercept Form Calculator - SolveKit"
    description="Free slope-intercept form calculator: y = mx + b from two points, a point and slope, or any equation."
    lede="Write a line as y = mx + b."
    about="In y = mx + b, m is the slope and b the y-intercept. From standard form Ax + By = C, m = −A/B and b = C/B."
    :calc="['engine' => 'mt-coord', 'tool' => 'line', 'fields' => ['given', 'x1', 'y1', 'x2', 'y2', 'm', 'b', 'eq'], 'want' => 'slopeIntercept']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Write the line through (1, 2) and (4, 8) as y = mx + b.', 'answer' => 'y = 2x.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['points' => 'Two points', 'point_slope' => 'A point and the slope', 'slope_intercept' => 'Slope and y-intercept', 'equation' => 'An equation']" selected="points" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points,point_slope">
            <x-calc.field name="x1" label="x₁" value="1" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:points,point_slope">
            <x-calc.field name="y1" label="y₁" value="2" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points">
            <x-calc.field name="x2" label="x₂" value="4" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:points">
            <x-calc.field name="y2" label="y₂" value="8" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:point_slope,slope_intercept" hidden>
            <x-calc.field name="m" label="Slope m" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:slope_intercept" hidden>
            <x-calc.field name="b" label="y-intercept b" value="-3" type="text" inputmode="decimal" />
        </div>
    </div>

    <div data-show-when="given:equation" hidden>
        <x-calc.field name="eq" label="Equation of the line" value="2x - 3y = 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Slope-intercept form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'points', 'x1' => '1', 'y1' => '2', 'x2' => '4', 'y2' => '8', 'm' => '2', 'b' => '-3', 'eq' => '2x - 3y = 6'],
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
            <li>y = mx + b</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
