<x-calc.page
    title="LM317 Calculator - SolveKit"
    description="Free LM317 calculator: output voltage from R1 and R2, or R2 for a target voltage, with E24 values and heat dissipation."
    lede="Set an LM317 regulator."
    about="The LM317 keeps 1.25 V across R1; R2 sets how much higher the output is."
    :calc="['engine' => 'tc-elec', 'tool' => 'lm317', 'fields' => ['mode', 'r1', 'r2', 'target', 'vin', 'iload'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What R2 gives 5 V with R1 = 240 Ω?', 'answer' => 'R2 = 713.2 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Find" :options="['vout' => 'Output voltage from R1 and R2', 'r2' => 'R2 for a target voltage']" selected="r2" />
        <x-calc.field name="r1" label="R1 (Ω)" value="240" min="1" step="any" />
        <div data-show-when="mode:vout">
            <x-calc.field name="r2" label="R2 (Ω)" value="720" min="0" step="any" />
        </div>
        <div data-show-when="mode:r2">
            <x-calc.field name="target" label="Target output (V)" value="5" min="1.25" step="any" />
        </div>
        <x-calc.field name="vin" label="Input voltage (V)" value="9" min="0" step="any" />
        <x-calc.field name="iload" label="Load current (A)" value="0.5" min="0" step="any" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'r2', 'r1' => 240, 'r2' => 720, 'target' => 5, 'vin' => 9, 'iload' => 0.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'vout' => ['label' => 'Output voltage'],
            'e24' => ['label' => 'Nearest E24 R2 and its output'],
            'headroom' => ['label' => 'Input headroom'],
            'power' => ['label' => 'Power in the regulator'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
