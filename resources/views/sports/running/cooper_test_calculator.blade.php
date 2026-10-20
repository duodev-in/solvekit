<x-calc.page
    title="Cooper Test Calculator - SolveKit"
    description="Free Cooper test calculator: VO₂max from the distance run in 12 minutes."
    lede="Score a Cooper test."
    about="Kenneth Cooper’s 12-minute run predicts VO₂max from distance covered."
    :calc="['engine' => 'sp-run', 'tool' => 'cooper', 'fields' => ['d', 'age', 'sex'], 'unitFields' => ['d' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What VO₂max does 2,400 m give?', 'answer' => '42.4 ml/kg/min.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="d" label="Distance in 12 minutes" value="2400" placeholder="Distance in 12 minutes">
            <label for="calc-d-unit" class="sr-only">Distance in 12 minutes unit</label>
            <select id="calc-d-unit" name="d-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="age" label="Age" value="30" min="1" step="any" />
        <x-calc.select name="sex" label="Sex" :options="['male' => 'Male', 'female' => 'Female']" selected="male" />
    </div>

    <x-calc.result label="Estimated VO₂max" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['d' => 2400, 'd-unit' => 'm', 'age' => 30, 'sex' => 'male'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rating' => ['label' => 'Rating'],
            'pace' => ['label' => 'Average pace'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
