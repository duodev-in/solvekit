<x-calc.page
    title="Electricity Cost Calculator - SolveKit"
    description="Free electricity cost calculator: what a device costs to run per use, day, month and year from its watts and hours of use, or from kWh, at your electricity price."
    lede="Work out what electricity costs, from one use to a year."
    about="Cost = kWh × price, and kWh = watts × hours ÷ 1,000. One use of a 1,500 W kettle for 3 minutes is 0.075 kWh, about 1.3¢ at 17¢/kWh. The single-use mode answers questions like that; the other modes give daily, monthly and yearly costs."
    :calc="['engine' => 'ev-home', 'tool' => 'electricity', 'fields' => ['mode', 'watts', 'hours', 'minutes', 'uses', 'kwh_month', 'price']]"
    :how-to="[
        ['name' => 'Choose the mode', 'text' => 'Device, one use or kWh.'],
        ['name' => 'Enter power, time and price', 'text' => 'From the label and your bill.'],
    ]"
    :faqs="[
        ['question' => 'How much does it cost to run a 1,500 W heater for 3 hours?', 'answer' => '4.5 kWh: about 77¢ at 17¢/kWh, $23 a month.'],
        ['question' => 'What does one kettle boil cost?', 'answer' => 'About 1.3¢ for 3 minutes at 1,500 W.'],
        ['question' => 'What is the average US electricity price?', 'answer' => 'Check your bill: the price per kWh varies by state and plan.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['device' => 'Device per day', 'once' => 'One use', 'kwh' => 'From kWh']" selected="device" />

    <div data-show-when="mode:device,once">
        <x-calc.field name="watts" label="Power" value="1500" min="0" suffix="W" />
    </div>

    <div data-show-when="mode:device">
        <x-calc.field name="hours" label="Hours a day" value="3" min="0" max="24" step="0.25" />
    </div>

    <div data-show-when="mode:once" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="minutes" label="Minutes per use" value="3" min="0" step="0.5" />
            <x-calc.field name="uses" label="Uses a day (optional)" value="4" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:kwh" hidden>
        <x-calc.field name="kwh_month" label="kWh a month" value="850" min="0" />
    </div>

    <x-calc.field name="price" label="Electricity price" value="0.17" min="0" step="0.01" suffix="$/kWh" />

    <x-calc.result label="Cost a month" />

    <x-calc.options :decimals="false" :examples="[
        'Space heater 3 h a day' => ['mode' => 'device', 'watts' => 1500, 'hours' => 3, 'minutes' => '', 'uses' => '', 'kwh_month' => '', 'price' => 0.17],
        'Kettle, one boil' => ['mode' => 'once', 'watts' => 1500, 'hours' => '', 'minutes' => 3, 'uses' => 4, 'kwh_month' => '', 'price' => 0.17],
        '850 kWh a month' => ['mode' => 'kwh', 'watts' => '', 'hours' => '', 'minutes' => '', 'uses' => '', 'kwh_month' => 850, 'price' => 0.17],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:device,kwh">
            <x-calc.rows heading="Details" :rows="[
                'day' => ['label' => 'Per day'],
                'month' => ['label' => 'Energy a month'],
                'year' => ['label' => 'Per year'],
                'kwh' => ['label' => 'Energy a year'],
            ]" />
        </div>
        <div data-show-when="mode:once" hidden>
            <x-calc.rows heading="Details" :rows="[
                'kwh' => ['label' => 'Energy per use'],
                'day' => ['label' => 'Per day'],
                'month' => ['label' => 'Per month'],
                'year' => ['label' => 'Per year'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kWh = W × h ÷ 1,000</li>
            <li>cost = kWh × price</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
