<x-calc.page
    title="Arrhenius Equation Calculator - SolveKit"
    description="Free Arrhenius equation calculator: solve k = A e^(-Ea/RT) for the rate constant, pre-exponential factor, activation energy or temperature."
    lede="Solve the Arrhenius equation for any one of k, A, Ea or T."
    about="The Arrhenius equation k = A e^(−Ea/RT) relates a rate constant to temperature. A is the pre-exponential (frequency) factor in the same units as k, Ea the activation energy and R = 8.314 J/(mol·K)."
    :calc="['engine' => 'chem-reactions', 'tool' => 'arrhenius', 'fields' => ['solve', 'k', 'a', 'ea', 'temperature'], 'unitFields' => ['temperature' => collect(config('units.temperature'))->only(['c', 'k', 'f'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'k, A, Ea or T.'],
        ['name' => 'Enter the other three', 'text' => 'A and k in the same units.'],
    ]"
    :faqs="[
        ['question' => 'What does the Arrhenius equation show?', 'answer' => 'How quickly a rate constant rises with temperature.'],
        ['question' => 'What is the pre-exponential factor?', 'answer' => 'The rate constant if every collision had enough energy.'],
        ['question' => 'Why does a 10 °C rise often double the rate?', 'answer' => 'For Ea near 50 kJ/mol at room temperature, k roughly doubles per 10 °C.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['k' => 'Rate constant k', 'a' => 'Pre-exponential factor A', 'ea' => 'Activation energy Ea', 't' => 'Temperature T']" selected="k" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:a,ea,t" hidden>
            <x-calc.field name="k" label="Rate constant k" value="3e-05" min="0" />
        </div>
        <div data-show-when="solve:k,ea,t">
            <x-calc.field name="a" label="Pre-exponential factor A" value="10000000000000.0" min="0" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:k,a,t">
            <x-calc.field name="ea" label="Activation energy" value="100" min="0" suffix="kJ/mol" />
        </div>
        <div data-show-when="solve:k,a,ea">
            <x-calc.field name="temperature" label="Temperature" value="25" placeholder="Temperature">
                <label for="calc-temperature-unit" class="sr-only">Temperature unit</label>
                <select id="calc-temperature-unit" name="temperature-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'k', 'f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :examples="[
        'k at 25 °C' => ['solve' => 'k', 'a' => 10000000000000.0, 'ea' => 100, 'temperature' => 25, 'temperature-unit' => 'c'],
        'Ea from k and A' => ['solve' => 'ea', 'k' => 3e-05, 'a' => 10000000000000.0, 'temperature' => 25, 'temperature-unit' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'kelvin' => ['label' => 'Temperature'],
            'fraction' => ['label' => 'Boltzmann factor'],
        ]" />
        <x-calc.quick-ref heading="k nearby" name="temperatures" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>k = A e^(−Ea / RT)</li>
            <li>R = 8.314 462 618 J/(mol·K)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
