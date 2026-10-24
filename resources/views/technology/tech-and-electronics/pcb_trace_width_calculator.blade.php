<x-calc.page
    title="PCB Trace Width Calculator - SolveKit"
    description="Free PCB trace width calculator: minimum width for a current, copper weight and temperature rise (IPC-2221)."
    lede="Find the trace width."
    about="The trace must be wide enough that the current does not heat it beyond the allowed rise."
    :calc="['engine' => 'tc-elec', 'tool' => 'trace_width', 'fields' => ['current', 'oz', 'dT', 'layer'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How wide for 2 A on 1 oz copper, outer layer?', 'answer' => '0.7814 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="current" label="Current (A)" value="2" min="0" step="any" />
        <x-calc.field name="oz" label="Copper weight (oz/ft²)" value="1" min="0" step="any" />
        <x-calc.field name="dT" label="Allowed temperature rise (°C)" value="10" min="0" step="any" />
        <x-calc.select name="layer" label="Layer" :options="['external' => 'External (outer)', 'internal' => 'Internal']" selected="external" />
    </div>

    <x-calc.result label="Minimum trace width (IPC-2221)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['current' => 2, 'oz' => 1, 'dT' => 10, 'layer' => 'external'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mil' => ['label' => 'In mils'],
            'area' => ['label' => 'Cross-section'],
            'other' => ['label' => 'On the other layer type'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
