<x-calc.page
    title="Line Equation from Two Points Calculator - SolveKit"
    description="Free line from two points calculator: slope-intercept, point-slope and standard form of the line through two points, exactly."
    lede="Find the line through two points."
    about="Two points fix a line. Find the slope m = Δy/Δx, then b from y = mx + b. Through (1, 2) and (4, 8): m = 2, b = 0, so y = 2x (standard form 2x − y = 0)."
    :calc="['engine' => 'mt-coord', 'tool' => 'line', 'fields' => ['given', 'x1', 'y1', 'x2', 'y2'], 'want' => 'slopeIntercept']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'What line passes through (1, 2) and (4, 8)?', 'answer' => 'y = 2x.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['points' => 'Two points']" selected="points" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:points">
            <x-calc.field name="x1" label="x₁" value="1" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="given:points">
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

    <x-calc.result label="Slope-intercept form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'points', 'x1' => '1', 'y1' => '2', 'x2' => '4', 'y2' => '8', 'm' => '2', 'b' => '-3', 'eq' => '2x - 3y = 6'],
        'Fractions' => ['given' => 'points', 'x1' => '1/2', 'y1' => '-1', 'x2' => '3', 'y2' => '4', 'm' => '2', 'b' => '-3', 'eq' => '2x - 3y = 6'],
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
