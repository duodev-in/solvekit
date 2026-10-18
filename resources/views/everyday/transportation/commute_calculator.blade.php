<x-calc.page
    title="Commute Calculator - SolveKit"
    description="Free commute calculator: hours a year spent commuting, the cost by car or transit, and the distance traveled."
    lede="See how much time and money your commute takes each year."
    about="Trips a year = 2 × days a week × weeks a year. Time = trips × one-way minutes; cost = miles × cost per mile, or trips × fare. For a car's full running cost, use about the IRS business rate (76¢ a mile from July 2026), which includes fuel, wear and depreciation."
    :calc="['engine' => 'ev-transport', 'tool' => 'commute', 'fields' => ['minutes', 'distance', 'days', 'weeks', 'cost_mode', 'per_mile', 'fare'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the one-way trip', 'text' => 'Minutes, and miles if you know them.'],
        ['name' => 'Enter the cost', 'text' => 'Per mile for a car, per trip for transit.'],
    ]"
    :faqs="[
        ['question' => 'How many hours a year is a 35-minute commute?', 'answer' => '280 hours over 48 five-day weeks: almost 12 full days.'],
        ['question' => 'What does a car commute cost per mile?', 'answer' => 'The IRS business rate, 76¢ a mile from July 2026, is a fair all-in estimate.'],
        ['question' => 'What is the average US commute?', 'answer' => 'About 27 minutes each way (US Census Bureau, American Community Survey).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="minutes" label="One-way time" value="35" min="1" step="1" suffix="min" />
        <x-calc.field name="distance" label="One-way distance (optional)" value="15" min="0" placeholder="One-way distance (optional)">
            <label for="calc-distance-unit" class="sr-only">One-way distance (optional) unit</label>
            <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['km', 'mi', 'nmi', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mi')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="days" label="Days a week" value="5" min="1" max="7" step="1" />
        <x-calc.field name="weeks" label="Weeks a year" value="48" min="1" max="52" step="1" />
    </div>

    <x-calc.segmented name="cost_mode" legend="Cost" :options="['per_mile' => 'Per mile', 'per_trip' => 'Per trip (fare)']" selected="per_mile" />

    <div data-show-when="cost_mode:per_mile">
        <x-calc.field name="per_mile" label="Cost per mile" value="0.76" min="0" step="0.01" suffix="$" />
    </div>

    <div data-show-when="cost_mode:per_trip" hidden>
        <x-calc.field name="fare" label="Fare per trip" value="2.9" min="0" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Time spent commuting" />

    <x-calc.options :examples="[
        '35 min, 15 mi by car' => ['minutes' => 35, 'distance' => 15, 'distance-unit' => 'mi', 'days' => 5, 'weeks' => 48, 'cost_mode' => 'per_mile', 'per_mile' => 0.76, 'fare' => ''],
        'Transit, $2.90 fare' => ['minutes' => 50, 'distance' => 12, 'distance-unit' => 'mi', 'days' => 5, 'weeks' => 48, 'cost_mode' => 'per_trip', 'per_mile' => '', 'fare' => 2.9],
        'Hybrid, 3 days' => ['minutes' => 60, 'distance' => 40, 'distance-unit' => 'km', 'days' => 3, 'weeks' => 46, 'cost_mode' => 'per_mile', 'per_mile' => 0.5, 'fare' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'days' => ['label' => 'In days'],
            'cost' => ['label' => 'Cost'],
            'distance' => ['label' => 'Distance'],
            'week' => ['label' => 'Per week'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hours = 2 × days × weeks × minutes ÷ 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
