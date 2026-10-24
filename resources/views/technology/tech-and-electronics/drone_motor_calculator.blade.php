<x-calc.page
    title="Drone Motor Calculator - SolveKit"
    description="Free drone motor calculator: thrust each motor needs for your weight and thrust-to-weight ratio."
    lede="Find the thrust per motor."
    about="A drone needs more thrust than its weight to climb and manoeuvre: 2:1 for gentle flying, much more for racing."
    :calc="['engine' => 'tc-elec', 'tool' => 'drone_motor', 'fields' => ['weight', 'motors', 'twr'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How much thrust per motor for a 1.2 kg quad at 2:1?', 'answer' => '600 g.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="All-up weight (g)" value="1200" min="0" step="any" />
        <x-calc.select name="motors" label="Motors" :options="['3' => '3 (tricopter)', '4' => '4 (quadcopter)', '6' => '6 (hexacopter)', '8' => '8 (octocopter)']" selected="4" />
        <x-calc.select name="twr" label="Thrust-to-weight ratio" :options="['2' => '2:1 (camera, gentle flying)', '3' => '3:1 (sport)', '5' => '5:1 (racing)', '8' => '8:1 (racing, very agile)']" selected="2" />
    </div>

    <x-calc.result label="Thrust needed per motor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 1200, 'motors' => '4', 'twr' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'total' => ['label' => 'Total thrust'],
            'hover' => ['label' => 'Thrust per motor at hover'],
            'note' => ['label' => 'Choosing a motor'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
