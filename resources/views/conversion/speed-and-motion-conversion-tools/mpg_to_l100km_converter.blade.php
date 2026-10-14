@php
    $units = config('units.fuel_economy');
@endphp

<x-calc.page
    title="MPG to L/100km Converter - SolveKit"
    description="Professional fuel economy converter between miles per gallon and liters per 100 kilometers. Convert vehicle fuel efficiency for international automotive comparisons."
    lede="Convert miles per gallon to liters per 100 km and other fuel economy units."
    about="MPG measures distance per fuel and L/100 km measures fuel per distance, so one is the inverse of the other: L/100 km = 235.215 ÷ US mpg (or 282.481 ÷ UK mpg). Electric units use the EPA equivalence of 33.705 kWh per gallon of gasoline."
    :calc="['engine' => 'units', 'units' => $units, 'list' => array_keys($units), 'min' => 0]"
    :how-to="[
        ['name' => 'Enter a fuel economy figure', 'text' => 'Type the amount you want to convert.'],
        ['name' => 'Choose the units', 'text' => 'Pick the unit you have and the unit you want, or swap them.'],
        ['name' => 'Read or copy the result', 'text' => 'Every other unit is listed beside the result. Click a row to copy it.'],
    ]"
    :faqs="[
        ['question' => 'How do I convert mpg to L/100 km?', 'answer' => 'Divide 235.215 by the US mpg. 30 mpg is 7.84 L/100 km.'],
        ['question' => 'Why are UK mpg figures higher?', 'answer' => 'An imperial gallon is about 20% larger than a US gallon, so the same car goes further per gallon.'],
        ['question' => 'Is a lower L/100 km better?', 'answer' => 'Yes. L/100 km is fuel used, so lower means more efficient. Higher mpg is better.'],
        ['question' => 'What is MPGe?', 'answer' => 'Miles per gallon equivalent: the distance an electric car travels on 33.705 kWh, the energy in one US gallon of gasoline.'],
    ]"
>
    <x-calc.unit-pair :units="$units" from="mpg_us" to="l100km" value="30" min="0" label="Fuel economy" />

    <x-calc.result label="Liters per 100 km">
        <p class="text-xs text-slate-500" data-ref="ratio"></p>
    </x-calc.result>

    <x-calc.options :examples="[
        'Hybrid 50 mpg' => ['value' => 50, 'from' => 'mpg_us'],
        'European car 6 L/100 km' => ['value' => 6, 'from' => 'l100km'],
        'EV 30 kWh/100 mi' => ['value' => 30, 'from' => 'kwh100mi'],
    ]" />

    <x-slot:panel>
        <x-calc.unit-list :units="$units" heading="30 mpg in other units" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L/100 km = 235.2146 ÷ mpg (US)</li>
            <li>L/100 km = 282.4809 ÷ mpg (UK)</li>
            <li>km/L = 100 ÷ L/100 km</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
