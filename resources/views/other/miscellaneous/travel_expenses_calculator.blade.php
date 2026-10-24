<x-calc.page
    title="Travel Expenses - SolveKit"
    description="Free travel expenses calculator: trip cost from transport, lodging, food and activities, per person and per day."
    lede="Budget a trip."
    about="A trip budget adds transport, lodging, food and activities."
    :calc="['engine' => 'ot-misc', 'tool' => 'travel', 'fields' => ['travellers', 'days', 'by', 'fares', 'distance', 'economy', 'fuel', 'lodging', 'food', 'activities'], 'unitFields' => ['distance' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all()], 'currency' => 'USD']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What does the example trip cost?', 'answer' => '$1,230.80.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="travellers" label="Travellers" value="2" min="1" step="any" />
        <x-calc.field name="days" label="Days" value="5" min="1" step="any" />
        <x-calc.select name="by" label="Getting there" :options="['fare' => 'Fares (total)', 'drive' => 'Driving']" selected="drive" />
        <div data-show-when="by:fare">
            <x-calc.field name="fares" label="Fares for everyone" value="600" min="0" step="any" suffix="$" />
        </div>
        <div data-show-when="by:drive">
            <x-calc.field name="distance" label="Round-trip distance" value="900" placeholder="Round-trip distance">
                <label for="calc-distance-unit" class="sr-only">Round-trip distance unit</label>
                <select id="calc-distance-unit" name="distance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'km')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="by:drive">
            <x-calc.field name="economy" label="Fuel use (L/100 km)" value="7" min="0" step="any" />
        </div>
        <div data-show-when="by:drive">
            <x-calc.field name="fuel" label="Fuel price per litre" value="1.6" min="0" step="any" suffix="$" />
        </div>
        <x-calc.field name="lodging" label="Lodging per night" value="120" min="0" step="any" suffix="$" />
        <x-calc.field name="food" label="Food per person per day" value="45" min="0" step="any" suffix="$" />
        <x-calc.field name="activities" label="Activities and extras (total)" value="200" min="0" step="any" suffix="$" />
    </div>

    <x-calc.result label="Trip cost" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['travellers' => 2, 'days' => 5, 'by' => 'drive', 'fares' => 600, 'distance' => 900, 'distance-unit' => 'km', 'economy' => 7, 'fuel' => 1.6, 'lodging' => 120, 'food' => 45, 'activities' => 200],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'perPerson' => ['label' => 'Per person'],
            'perDay' => ['label' => 'Per day'],
            'breakdown' => ['label' => 'Transport, lodging, food, activities'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
