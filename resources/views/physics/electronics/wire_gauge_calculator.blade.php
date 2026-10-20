<x-calc.page
    title="Wire Gauge Calculator - SolveKit"
    description="Free wire gauge calculator: diameter, area and resistance for AWG, SWG and metric wire sizes."
    lede="Look up a wire gauge."
    about="AWG sizes follow a geometric rule; SWG sizes come from the 1883 British standard table; metric sizes are quoted by area."
    :calc="['engine' => 'ph-elec', 'tool' => 'wire_gauge', 'fields' => ['system', 'awg', 'swg', 'mm2', 'out'], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How thick is 12 AWG?', 'answer' => '2.05253 mm.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="system" label="Gauge system" :options="['awg' => 'AWG (American)', 'swg' => 'SWG (British Imperial)', 'metric' => 'Metric (mm²)']" selected="awg" />
        <div data-show-when="system:awg">
            <x-calc.select name="awg" label="AWG size" :options="['0' => '0 (1/0)', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '-3' => '0000 (4/0)', '-2' => '000 (3/0)', '-1' => '00 (2/0)']" selected="12" />
        </div>
        <div data-show-when="system:swg">
            <x-calc.select name="swg" label="SWG size" :options="['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35', '36' => '36', '37' => '37', '38' => '38', '39' => '39', '40' => '40', '7/0' => '7/0', '6/0' => '6/0', '5/0' => '5/0', '4/0' => '4/0', '3/0' => '3/0', '2/0' => '2/0']" selected="14" />
        </div>
        <div data-show-when="system:metric">
            <x-calc.select name="mm2" label="Metric size" :options="['1' => '1 mm²', '4' => '4 mm²', '6' => '6 mm²', '10' => '10 mm²', '16' => '16 mm²', '25' => '25 mm²', '35' => '35 mm²', '50' => '50 mm²', '70' => '70 mm²', '95' => '95 mm²', '120' => '120 mm²', '150' => '150 mm²', '185' => '185 mm²', '240' => '240 mm²', '300' => '300 mm²', '0.5' => '0.5 mm²', '0.75' => '0.75 mm²', '1.5' => '1.5 mm²', '2.5' => '2.5 mm²']" selected="2.5" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
    </div>

    <x-calc.result label="Diameter (solid conductor)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mm', 'system' => 'awg', 'awg' => '12', 'swg' => '14', 'mm2' => '2.5'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Cross-section area'],
            'kcmil' => ['label' => 'In kcmil'],
            'R' => ['label' => 'Copper resistance at 20 °C'],
            'nearest' => ['label' => 'Nearest AWG'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
