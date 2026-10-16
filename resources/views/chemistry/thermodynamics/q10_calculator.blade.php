<x-calc.page
    title="Q10 Calculator - SolveKit"
    description="Free Q10 calculator: the temperature coefficient of a rate from two temperatures, or a rate at a new temperature."
    lede="Work out the Q10 temperature coefficient, or predict a rate at another temperature."
    about="Q10 is the factor by which a rate changes for a 10 °C rise: Q10 = (R₂ ÷ R₁)^(10 ÷ (T₂ − T₁)). Biological and enzyme processes typically have Q10 of 2 to 3."
    :calc="['engine' => 'chem-thermo', 'tool' => 'q10', 'fields' => ['mode', 'r1', 't1', 'r2', 'q10', 't2']]"
    :how-to="[
        ['name' => 'Enter the rates', 'text' => 'At two temperatures.'],
        ['name' => 'Or predict', 'text' => 'With a known Q10.'],
    ]"
    :faqs="[
        ['question' => 'What is a typical Q10?', 'answer' => 'About 2 to 3 for many biological processes.'],
        ['question' => 'What does Q10 = 1 mean?', 'answer' => 'The rate does not depend on temperature.'],
        ['question' => 'How is Q10 related to activation energy?', 'answer' => 'Higher activation energy gives a larger Q10.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Find" :options="['rates' => 'Q10 from two rates', 'predict' => 'A new rate']" selected="rates" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="r1" label="Rate R₁" value="2" min="0" />
        <x-calc.field name="t1" label="Temperature T₁" value="20" suffix="°C" />
    </div>

    <div data-show-when="mode:rates">
        <x-calc.field name="r2" label="Rate R₂" value="4" min="0" />
    </div>

    <div data-show-when="mode:predict" hidden>
        <x-calc.field name="q10" label="Q10" value="2.5" min="0" />
    </div>

    <x-calc.field name="t2" label="Temperature T₂" value="30" suffix="°C" />

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'Rate doubles over 10 °C' => ['mode' => 'rates', 'r1' => 2, 't1' => 20, 'r2' => 4, 't2' => 30],
        'Predict at 37 °C' => ['mode' => 'predict', 'r1' => 10, 't1' => 25, 'q10' => 2.5, 't2' => 37],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'factor' => ['label' => 'Rate change'],
            'q10' => ['label' => 'Q10'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Q10 = (R₂ ÷ R₁)^(10 ÷ (T₂ − T₁))</li>
            <li>R₂ = R₁ × Q10^((T₂ − T₁) ÷ 10)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
