<x-calc.page
    title="Nernst Equation Calculator - SolveKit"
    description="Free Nernst equation calculator: electrode or cell potential from E°, electrons, temperature and the reaction quotient or concentrations."
    lede="Work out an electrode or cell potential with the Nernst equation."
    about="E = E° − (RT ÷ nF) ln Q. At 25 °C this is E° − (0.05916 ÷ n) log₁₀ Q. For a single electrode Ox + ne⁻ ⇌ Red, Q = [Red] ÷ [Ox]; pure solids count as 1."
    :calc="['engine' => 'chem-electro', 'tool' => 'nernst', 'fields' => ['standard', 'electrons', 'mode', 'q', 'oxidized', 'reduced', 'temperature']]"
    :how-to="[
        ['name' => 'Enter E° and n', 'text' => 'From the half-reaction.'],
        ['name' => 'Enter Q', 'text' => 'Or the oxidized and reduced concentrations.'],
    ]"
    :faqs="[
        ['question' => 'What is the Nernst equation?', 'answer' => 'E = E° − (RT ÷ nF) ln Q, the potential away from standard conditions.'],
        ['question' => 'What is 59 mV per decade?', 'answer' => 'At 25 °C a tenfold change in Q shifts E by 59.16 mV ÷ n.'],
        ['question' => 'How does a pH electrode use it?', 'answer' => 'Its potential changes by about 59 mV per pH unit.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="standard" label="Standard potential E°" value="0.34" suffix="V" />
        <x-calc.field name="electrons" label="Electrons n" value="2" min="1" step="1" />
    </div>

    <x-calc.segmented name="mode" legend="Q from" :options="['q' => 'Q value', 'concentrations' => 'Concentrations']" selected="concentrations" />

    <div data-show-when="mode:q" hidden>
        <x-calc.field name="q" label="Reaction quotient Q" value="10" min="0" />
    </div>

    <div data-show-when="mode:concentrations">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="oxidized" label="[Oxidized form]" value="0.01" min="0" suffix="M" />
            <x-calc.field name="reduced" label="[Reduced form]" value="1" min="0" suffix="M" help="1 for a pure metal" />
        </div>
    </div>

    <x-calc.field name="temperature" label="Temperature" value="25" suffix="°C" />

    <x-calc.result label="Potential" />

    <x-calc.options :examples="[
        'Cu²⁺ at 0.01 M' => ['standard' => 0.34, 'electrons' => 2, 'mode' => 'concentrations', 'oxidized' => 0.01, 'reduced' => 1, 'temperature' => 25],
        'Cell with Q = 10' => ['standard' => 1.1, 'electrons' => 2, 'mode' => 'q', 'q' => 10, 'temperature' => 25],
        'At body temperature' => ['standard' => 0.34, 'electrons' => 2, 'mode' => 'concentrations', 'oxidized' => 0.001, 'reduced' => 1, 'temperature' => 37],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'shift' => ['label' => 'Shift from E°'],
            'q' => ['label' => 'Q'],
            'gibbs' => ['label' => 'ΔG'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = E° − (RT ÷ nF) ln Q</li>
            <li>at 25 °C: E = E° − (0.05916 ÷ n) log Q</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
