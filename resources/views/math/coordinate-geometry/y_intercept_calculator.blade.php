<x-calc.page
    title="y Intercept Calculator - SolveKit"
    description="Free y-intercept calculator: where a line crosses the y-axis, from two points, a point and slope, or an equation."
    lede="Find the y-intercept."
    about="The y-intercept is the point where x = 0, (0, b). From two points, b = y₁ − m x₁; from Ax + By = C, b = C/B. The line through (2, 7) and (4, 11) crosses at (0, 3)."
    :calc="['engine' => 'mt-coord', 'tool' => 'line', 'fields' => ['given', 'x1', 'y1', 'x2', 'y2', 'm', 'b', 'eq'], 'want' => 'yint']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Where does the line through (2, 7) and (4, 11) cross the y-axis?', 'answer' => '(0, 3).'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['points' => 'Two points', 'point_slope' => 'A point and the slope', 'equation' => 'An equation']" selected="points" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points,point_slope">
            <x-calc.field name="x1" label="x₁" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:points,point_slope">
            <x-calc.field name="y1" label="y₁" value="7" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points">
            <x-calc.field name="x2" label="x₂" value="4" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:points">
            <x-calc.field name="y2" label="y₂" value="11" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:point_slope" hidden>
            <x-calc.field name="m" label="Slope m" value="2" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:none" hidden>
            <x-calc.field name="b" label="y-intercept b" value="-3" type="text" inputmode="decimal" />
        </div>
    </div>

    <div data-show-when="given:equation" hidden>
        <x-calc.field name="eq" label="Equation of the line" value="2x - 3y = 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="y-intercept" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'points', 'x1' => '2', 'y1' => '7', 'x2' => '4', 'y2' => '11', 'm' => '2', 'b' => '-3', 'eq' => '2x - 3y = 6'],
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
            <li>b = y₁ − m x₁</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
