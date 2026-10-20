<x-calc.page
    title="Modulation Calculator - SolveKit"
    description="Free AM modulation calculator: modulation index and sideband power from amplitudes or the envelope."
    lede="Find the AM modulation index."
    about="In amplitude modulation the modulation index m is the message amplitude over the carrier amplitude, or (max − min)/(max + min) of the envelope. Above 1 the signal distorts."
    :calc="['engine' => 'ph-wave', 'tool' => 'modulation', 'fields' => ['mode', 'Am', 'Ac', 'max', 'min'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is m for an envelope from 0.5 to 1.5?', 'answer' => '0.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['amp' => 'Carrier and message amplitudes', 'env' => 'Envelope maximum and minimum']" selected="env" />
        <div data-show-when="mode:amp">
            <x-calc.field name="Am" label="Message amplitude" value="0.5" min="0" step="any" />
        </div>
        <div data-show-when="mode:amp">
            <x-calc.field name="Ac" label="Carrier amplitude" value="1" min="0" step="any" />
        </div>
        <div data-show-when="mode:env">
            <x-calc.field name="max" label="Envelope maximum" value="1.5" min="0" step="any" />
        </div>
        <div data-show-when="mode:env">
            <x-calc.field name="min" label="Envelope minimum" value="0.5" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Modulation index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'env', 'Am' => 0.5, 'Ac' => 1, 'max' => 1.5, 'min' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'pct' => ['label' => 'Modulation depth'],
            'side' => ['label' => 'Power in the sidebands'],
            'total' => ['label' => 'Total power ÷ carrier power'],
            'status' => ['label' => 'Status'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
