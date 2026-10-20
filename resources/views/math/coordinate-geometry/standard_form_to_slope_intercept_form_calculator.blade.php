<x-calc.page
    title="Standard Form to Slope Intercept Form Calculator - SolveKit"
    description="Free standard form to slope-intercept calculator: rewrite Ax + By = C as y = mx + b."
    lede="Convert Ax + By = C to y = mx + b."
    about="Solve for y: By = −Ax + C, so y = (−A/B)x + C/B. 2x − 3y = 6 becomes y = (2/3)x − 2."
    :calc="['engine' => 'mt-coord', 'tool' => 'line', 'fields' => ['given', 'eq'], 'want' => 'slopeIntercept']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'Rewrite 2x − 3y = 6 in slope-intercept form.', 'answer' => 'y = (2/3)x − 2.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['equation' => 'An equation']" selected="equation" />

    <div data-show-when="given:equation">
        <x-calc.field name="eq" label="Equation of the line" value="2x - 3y = 6" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Slope-intercept form" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'equation', 'x1' => '1', 'y1' => '2', 'x2' => '4', 'y2' => '8', 'm' => '2', 'b' => '-3', 'eq' => '2x - 3y = 6'],
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
            <li>y = (−A/B)x + C/B</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
