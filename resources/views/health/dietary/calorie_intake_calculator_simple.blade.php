<x-calc.page
    title="Calorie Intake Calculator (Simple) - SolveKit"
    description="Free simple calorie intake calculator: daily calories from body weight and activity with the 25–35 kcal per kg rule."
    lede="A quick daily calorie estimate."
    about="A quick clinical rule estimates daily needs as 25 kcal/kg for low activity, 30 for moderate and 35 for high. It is simpler and rougher than equations that include height, age and sex. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-diet', 'tool' => 'simple_intake', 'fields' => ['weight', 'level'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Enter weight and activity', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many calories does a moderately active 70 kg adult need?', 'answer' => '2,100 kcal/day kcal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
            <label for="calc-weight-unit" class="sr-only">Weight unit</label>
            <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="level" label="Activity" :options="['low' => 'Low (25 kcal/kg)', 'moderate' => 'Moderate (30 kcal/kg)', 'high' => 'High (35 kcal/kg)']" selected="moderate" />
    </div>

    <x-calc.result label="Calorie intake" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['weight' => 70, 'weight-unit' => 'kg', 'level' => 'moderate'],
        'Low' => ['weight' => 180, 'weight-unit' => 'lb', 'level' => 'low'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'range' => ['label' => 'Range'],
            'rule' => ['label' => 'Rule'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>kcal = kg × 25–35</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
