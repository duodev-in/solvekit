<x-calc.page
    title="Landed Cost Calculator - SolveKit"
    description="Free landed cost calculator: product, freight, insurance, duty, taxes and fees per unit of imported goods."
    lede="Find the landed cost."
    about="Landed cost is what an imported product really costs once it reaches you."
    :calc="['engine' => 'ot-misc', 'tool' => 'landed_cost', 'fields' => ['units', 'price', 'freight', 'insurance', 'duty', 'basis', 'tax', 'fees'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the landed cost per unit in the example?', 'answer' => '$6.59.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="units" label="Units" value="1000" min="1" step="any" />
        <x-calc.field name="price" label="Product cost per unit" value="4.5" min="0" step="any" suffix="$" />
        <x-calc.field name="freight" label="Freight (total)" value="1200" min="0" step="any" suffix="$" />
        <x-calc.field name="insurance" label="Insurance (total)" value="60" min="0" step="any" suffix="$" />
        <x-calc.field name="duty" label="Duty rate (%)" value="10" min="0" step="any" />
        <x-calc.select name="basis" label="Duty charged on" :options="['cif' => 'CIF value (cost + insurance + freight)', 'fob' => 'FOB value (product only)']" selected="cif" />
        <x-calc.field name="tax" label="Import VAT / GST (% of value + duty, if not reclaimed)" value="0" min="0" step="any" />
        <x-calc.field name="fees" label="Other fees (customs broker, port, handling)" value="250" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Landed cost per unit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['units' => 1000, 'price' => 4.5, 'freight' => 1200, 'insurance' => 60, 'duty' => 10, 'basis' => 'cif', 'tax' => 0, 'fees' => 250],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total landed cost'],
            'duty' => ['label' => 'Duty'],
            'taxRow' => ['label' => 'Import tax'],
            'share' => ['label' => 'Share that is not the product'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
