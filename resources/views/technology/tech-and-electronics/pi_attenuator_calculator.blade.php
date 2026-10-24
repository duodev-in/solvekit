<x-calc.page
    title="Pi Attenuator Calculator - SolveKit"
    description="Free pi and T attenuator calculator: resistor values for any attenuation and impedance, with E24 values."
    lede="Design an attenuator."
    about="A pi or T attenuator reduces a signal by a set number of decibels while keeping both ends matched."
    :calc="['engine' => 'tc-elec', 'tool' => 'pi_attenuator', 'fields' => ['db', 'z', 'topology'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What resistors make a 10 dB, 50 Ω pi pad?', 'answer' => 'Shunt 96.25 Ω, series 71.15 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="db" label="Attenuation (dB)" value="10" min="0" step="any" />
        <x-calc.field name="z" label="Impedance Z₀ (Ω)" value="50" min="0" step="any" />
        <x-calc.select name="topology" label="Topology" :options="['pi' => 'Pi (two shunt, one series)', 't' => 'T (two series, one shunt)']" selected="pi" />
    </div>

    <x-calc.result label="Resistor values" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['db' => 10, 'z' => 50, 'topology' => 'pi'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'shunt' => ['label' => 'Shunt resistor(s)'],
            'series' => ['label' => 'Series resistor(s)'],
            'e24' => ['label' => 'Nearest E24 and the attenuation they give'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
