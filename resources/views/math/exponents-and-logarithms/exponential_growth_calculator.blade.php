<x-calc.page
    title="Exponential Growth Calculator - SolveKit"
    description="Free exponential growth calculator: final value, rate, time or initial value for discrete or continuous growth and decay, with doubling time and graph."
    lede="Calculate exponential growth or decay."
    about="Exponential growth multiplies by a fixed factor each period: P(t) = P₀(1 + r)ᵗ, or P₀e^(rt) when growth is continuous. A negative rate gives decay. Solve for any one of the four values; the doubling time (or half-life) is shown too."
    :calc="['engine' => 'mt-explog', 'tool' => 'growth', 'fields' => ['solve', 'model', 'p0', 'rate', 't', 'pt']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What does 1,000 become after 10 periods at 5%?', 'answer' => '1,628.894627.'],
        ['question' => 'How long does 1,000 take to double at 5%?', 'answer' => '14.20669908 periods.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="solve" label="Solve for" :options="['final' => 'Final value', 'rate' => 'Rate', 'time' => 'Time', 'initial' => 'Initial value']" selected="final" />
        <x-calc.select name="model" label="Growth" :options="['discrete' => 'Per period (1 + r)ᵗ', 'continuous' => 'Continuous eʳᵗ']" selected="discrete" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:rate,time,final" hidden>
            <x-calc.field name="p0" label="Initial value P₀" value="1000" step="any" />
        </div>
        <div data-show-when="solve:time,final,initial" hidden>
            <x-calc.field name="rate" label="Rate per period (%)" value="5" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:rate,final,initial" hidden>
            <x-calc.field name="t" label="Time (periods)" value="10" step="any" />
        </div>
        <div data-show-when="solve:rate,time,initial" hidden>
            <x-calc.field name="pt" label="Final value" value="2000" step="any" />
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'final', 'model' => 'discrete', 'p0' => 1000, 'rate' => 5, 't' => 10, 'pt' => 2000],
        'Time' => ['solve' => 'time', 'model' => 'discrete', 'p0' => 1000, 'rate' => 5, 't' => 10, 'pt' => 2000],
        'Decay' => ['solve' => 'final', 'model' => 'continuous', 'p0' => 500, 'rate' => -12, 't' => 8, 'pt' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Growth curve" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Formula'],
            'double' => ['label' => 'Doubling time or half-life'],
            'factor' => ['label' => 'Factor per period'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P(t) = P₀(1 + r)ᵗ</li>
            <li>P(t) = P₀e^(rt)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
