<x-calc.page
    title="VO2 Max Calculator - SolveKit"
    description="Free VO2 max calculator: estimate maximal oxygen uptake from a Cooper 12-minute run, a Rockport 1-mile walk or your resting heart rate."
    lede="Estimate your VO₂ max."
    about="VO₂ max is the best single measure of aerobic fitness. Cooper (1968): (metres run in 12 minutes − 504.9) ÷ 44.73. Rockport walk (Kline 1987): 132.853 − 0.0769 × weight (lb) − 0.3877 × age + 6.315 × male − 3.2649 × time (min) − 0.1565 × heart rate. Uth (2004): 15.3 × max HR ÷ resting HR. Field tests are estimates. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-life', 'tool' => 'vo2', 'fields' => ['method', 'distance', 'weight', 'time', 'hr', 'age', 'sex', 'rest'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['kg', 'lb', 'st'])->all()]]"
    :how-to="[
        ['name' => 'Choose a test', 'text' => ''],
        ['name' => 'Enter the result', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What VO₂ max does 2,400 m in 12 minutes give?', 'answer' => '42.4 mL/kg/min mL/kg/min.'],
        ['question' => 'And a 15:30 Rockport walk at 140 bpm (80 kg, 35, male)?', 'answer' => '39.5 mL/kg/min.'],
    ]"
>
    <x-calc.segmented name="method" legend="Test" :options="['cooper' => 'Cooper 12-minute run', 'rockport' => 'Rockport 1-mile walk', 'heartrate' => 'Resting heart rate']" selected="cooper" />

    <div data-show-when="method:cooper">
        <x-calc.field name="distance" label="Distance in 12 minutes" value="2400" min="0" step="any" suffix="m" />
    </div>

    <div data-show-when="method:rockport" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="weight" label="Weight" value="70" min="0" placeholder="Weight">
                <label for="calc-weight-unit" class="sr-only">Weight unit</label>
                <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'lb', 'st']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="time" label="Walk time (m:ss)" value="15:30" type="text" />
            <x-calc.field name="hr" label="Heart rate at the end" value="140" min="60" max="220" step="1" suffix="bpm" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="age" label="Age" value="35" min="0" step="1" suffix="years" />
        <x-calc.segmented name="sex" legend="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
        <div data-show-when="method:heartrate" hidden>
            <x-calc.field name="rest" label="Resting heart rate" value="62" min="30" max="120" step="1" suffix="bpm" />
        </div>
    </div>

    <x-calc.result label="Estimated VO₂ max" />

    <x-calc.options :decimals="false" :examples="[
        'Cooper' => ['method' => 'cooper', 'distance' => 2400, 'weight' => 80, 'weight-unit' => 'kg', 'time' => '15:30', 'hr' => 140, 'age' => 35, 'sex' => 'male', 'rest' => 62],
        'Rockport' => ['method' => 'rockport', 'distance' => 2400, 'weight' => 80, 'weight-unit' => 'kg', 'time' => '15:30', 'hr' => 140, 'age' => 35, 'sex' => 'male', 'rest' => 62],
        'Resting HR' => ['method' => 'heartrate', 'distance' => 2400, 'weight' => 80, 'weight-unit' => 'kg', 'time' => '15:30', 'hr' => 140, 'age' => 35, 'sex' => 'male', 'rest' => 62],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'mets' => ['label' => 'METs'],
            'method' => ['label' => 'Method'],
            'note' => ['label' => 'Accuracy'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Cooper: (d − 504.9) ÷ 44.73</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
