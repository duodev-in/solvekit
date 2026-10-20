<x-calc.page
    title="Scatter Plot Calculator - SolveKit"
    description="Free scatter plot calculator: plot paired data, measure the correlation and draw the trend line."
    lede="Make a scatter plot."
    about="A scatter plot shows paired data as points. The correlation coefficient r runs from −1 to 1: near ±1 the points hug a line, near 0 there is no linear pattern. Correlation does not prove causation."
    :calc="['engine' => 'mt-coord', 'tool' => 'regression', 'fields' => ['points', 'x0'], 'mode' => 'scatter']"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'How strongly are these heights and weights correlated?', 'answer' => 'r = 0.990038: Very strong positive linear relationship; trend y = 0.9371428571x − 94.65714286.'],
    ]"
>
    <x-calc.textarea name="points" label="Data points x, y (one per line)" value="160, 55
165, 61
170, 64
175, 70
180, 72
185, 80" rows="6" />

    <x-calc.field name="x0" label="Predict y at x = (optional)" value="" type="text" inputmode="decimal" />

    <x-calc.result label="Correlation" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['points' => '160, 55
165, 61
170, 64
175, 70
180, 72
185, 80', 'x0' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Scatter plot" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'r' => ['label' => 'Correlation r'],
            'r2' => ['label' => 'r²'],
            'equation' => ['label' => 'Trend line'],
            'means' => ['label' => 'Means'],
            'predict' => ['label' => 'Prediction'],
            'count' => ['label' => 'Points'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>r = Sxy ÷ √(Sxx Syy)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
