<x-calc.page
    title="Dog Water Intake Calculator - SolveKit"
    description="Free dog water intake calculator: how much water a dog needs a day by weight, activity and weather."
    lede="Work out how much water your dog needs each day."
    about="Healthy dogs drink about 50 to 60 mL per kg of body weight a day (roughly 1 fl oz per lb), more when active or hot, less on wet food. Drinking more than about 100 mL per kg a day can be a sign of illness such as diabetes or kidney disease."
    :calc="['engine' => 'pets', 'tool' => 'dog_water', 'fields' => ['weight', 'activity', 'weather'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the weight', 'text' => 'In lb or kg.'],
        ['name' => 'Set activity and weather', 'text' => 'Both raise water needs.'],
    ]"
    :faqs="[
        ['question' => 'How much water should a dog drink?', 'answer' => 'About 1 fl oz per lb (50 to 60 mL per kg) a day.'],
        ['question' => 'Why is my dog drinking more?', 'answer' => 'Heat, exercise and dry food raise intake; a lasting increase needs a vet check.'],
        ['question' => 'Does wet food count?', 'answer' => 'Yes, wet food is about 75% water.'],
    ]"
>
    <x-calc.field name="weight" label="Weight" value="40" min="0" placeholder="Weight">
        <label for="calc-weight-unit" class="sr-only">Weight unit</label>
        <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
            @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
            @endforeach
        </select>
    </x-calc.field>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.segmented name="activity" legend="Activity" :options="['normal' => 'Normal', 'active' => 'Very active']" selected="normal" />
        <x-calc.segmented name="weather" legend="Weather" :options="['mild' => 'Mild', 'hot' => 'Hot']" selected="mild" />
    </div>

    <x-calc.result label="Water per day" />

    <x-calc.options :examples="[
        '40 lb, mild' => ['weight' => 40, 'weight-unit' => 'lb', 'activity' => 'normal', 'weather' => 'mild'],
        '25 kg, active in heat' => ['weight' => 25, 'weight-unit' => 'kg', 'activity' => 'active', 'weather' => 'hot'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cups' => ['label' => 'In cups'],
            'liters' => ['label' => 'In liters'],
            'range' => ['label' => 'Normal at rest'],
            'high' => ['label' => 'See a vet if'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>water ≈ 55 mL × kg (50 to 60)</li>
            <li>+25% very active, +25% hot weather</li>
            <li>over 100 mL/kg/day is excessive</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
