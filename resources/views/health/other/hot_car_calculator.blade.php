<x-calc.page
    title="Hot Car Calculator - SolveKit"
    description="Free hot car calculator: how hot the inside of a parked car gets in minutes from the outside temperature, from measured data."
    lede="See how fast a parked car heats up."
    about="In a dark sedan parked in the sun, McLaren, Null & Quinn (Pediatrics 2005) measured an average rise of 19 °F in 10 minutes, 29 °F in 20, 34 °F in 30 and 43 °F in an hour, whatever the outside temperature, and cracking the windows barely helped. Children heat up 3–5 times faster than adults: never leave a child or pet in a car. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'hot_car', 'fields' => ['outside', 'minutes'], 'unitFields' => ['outside' => collect(config('units.temperature'))->only(['f', 'c'])->all()]]"
    :how-to="[
        ['name' => 'Enter the outside temperature', 'text' => ''],
        ['name' => 'Enter the minutes', 'text' => 'Up to an hour.'],
    ]"
    :faqs="[
        ['question' => 'How hot does a car get in 20 minutes on an 80 °F day?', 'answer' => '109 °F.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="outside" label="Outside temperature" value="80" placeholder="Outside temperature">
            <label for="calc-outside-unit" class="sr-only">Outside temperature unit</label>
            <select id="calc-outside-unit" name="outside-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'f')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="minutes" label="Minutes parked" value="20" min="0" max="60" step="1" />
    </div>

    <x-calc.result label="Inside the car" />

    <x-calc.options :decimals="false" :examples="[
        '80 °F' => ['outside' => 80, 'outside-unit' => 'f', 'minutes' => 20],
        '30 °C, one hour' => ['outside' => 30, 'outside-unit' => 'c', 'minutes' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rise' => ['label' => 'Rise'],
            'danger' => ['label' => 'Danger'],
            'curve' => ['label' => 'Measured curve'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>inside = outside + measured rise</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
