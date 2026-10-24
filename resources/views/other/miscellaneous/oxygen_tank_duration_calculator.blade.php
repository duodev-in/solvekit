<x-calc.page
    title="Oxygen Tank Duration Calculator - SolveKit"
    description="Free oxygen tank duration calculator: how long a D, E, M, G or H cylinder lasts at a flow rate."
    lede="Find oxygen cylinder duration."
    about="Each cylinder size has a factor in litres per psi; with the flow rate it gives the time left."
    :calc="['engine' => 'ot-misc', 'tool' => 'oxygen', 'fields' => ['cylinder', 'psi', 'flow', 'residual'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['oxygen'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long does a full E cylinder last at 2 L/min?', 'answer' => 'About 4 h 12 min 00 s to the safe residual.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="cylinder" label="Cylinder" :options="['d' => 'D cylinder', 'e' => 'E cylinder', 'm' => 'M cylinder', 'g' => 'G cylinder', 'h' => 'H / K cylinder']" selected="e" />
        <x-calc.field name="psi" label="Gauge pressure (psi)" value="2000" min="0" step="any" />
        <x-calc.field name="flow" label="Flow rate (L/min)" value="2" min="0" step="any" />
        <x-calc.field name="residual" label="Safe residual pressure (psi)" value="200" min="0" step="any" />
    </div>

    <x-calc.result label="Time until the safe residual" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['cylinder' => 'e', 'psi' => 2000, 'flow' => 2, 'residual' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'empty' => ['label' => 'Time until empty'],
            'litres' => ['label' => 'Oxygen above the residual'],
            'factor' => ['label' => 'Cylinder factor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
