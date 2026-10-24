<x-calc.page
    title="3D Printing Cost Calculator - SolveKit"
    description="Free 3D printing cost calculator: filament, electricity, machine wear, labour and failed prints, with a selling price."
    lede="Find what a 3D print costs."
    about="The cost of a print is the filament it uses plus the electricity, wear on the printer and your time, spread over the prints that fail."
    :calc="['engine' => 'tc-elec', 'tool' => 'print_cost', 'fields' => ['weight', 'spoolPrice', 'hours', 'watts', 'kwh', 'wear', 'labour', 'fail', 'margin'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does the example print cost?', 'answer' => '$9.97, of which filament is $2.64.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Part weight (g)" value="120" min="0" step="any" />
        <x-calc.field name="spoolPrice" label="Filament price per kg" value="22" min="0" step="any" suffix="$" />
        <x-calc.field name="hours" label="Print time (hours)" value="6" min="0" step="any" />
        <x-calc.field name="watts" label="Printer power (W)" value="150" min="0" step="any" />
        <x-calc.field name="kwh" label="Electricity price per kWh" value="0.15" min="0" step="any" suffix="$" />
        <x-calc.field name="wear" label="Machine wear per hour" value="0.2" min="0" step="any" suffix="$" />
        <x-calc.field name="labour" label="Labour (setup and finishing)" value="5" min="0" step="any" suffix="$" />
        <x-calc.field name="fail" label="Failure rate (%)" value="10" min="0" step="any" />
        <x-calc.field name="margin" label="Profit margin (%)" value="0" min="0" step="any" />
    </div>

    <x-calc.result label="Cost per print" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 120, 'spoolPrice' => 22, 'hours' => 6, 'watts' => 150, 'kwh' => 0.15, 'wear' => 0.2, 'labour' => 5, 'fail' => 10, 'margin' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'material' => ['label' => 'Filament'],
            'energy' => ['label' => 'Electricity'],
            'machine' => ['label' => 'Machine wear'],
            'labourRow' => ['label' => 'Labour'],
            'price' => ['label' => 'Price with margin'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
