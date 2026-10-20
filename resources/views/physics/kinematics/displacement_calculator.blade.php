<x-calc.page
    title="Displacement Calculator - SolveKit"
    description="Free displacement calculator: find displacement from initial velocity, acceleration and time, or any other three motion values."
    lede="Find how far something moves with constant acceleration."
    about="Displacement is the change in position, with a direction. For constant acceleration it follows from any three of the five motion quantities (s, u, v, a, t). Pick which three you know and the calculator uses the right equation of motion, then gives the other two as well. Also known as s = ut + ½at² calculator."
    :calc="['engine' => 'ph-mech', 'tool' => 'displacement', 'fields' => ['known', 's', 'u', 'v', 'a', 't', 'out'], 'unitFields' => ['s' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'u' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'a' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How far does a car go from rest at 2 m/s² for 10 s?', 'answer' => '100 m.'],
        ['question' => 'What is the difference between displacement and distance?', 'answer' => 'Distance is the path length; displacement is the straight-line change in position. They differ if the object turns back.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="known" label="I know" :options="['uat' => 'u, a and t', 'uvt' => 'u, v and t', 'uva' => 'u, v and a', 'vat' => 'v, a and t', 'sut' => 's, u and t', 'svt' => 's, v and t', 'suv' => 's, u and v', 'sua' => 's, u and a', 'sva' => 's, v and a', 'sat' => 's, a and t']" selected="uat" />
        <div data-show-when="known:sut,svt,suv,sua,sva,sat">
            <x-calc.field name="s" label="Displacement s" value="100" placeholder="Displacement s">
                <label for="calc-s-unit" class="sr-only">Displacement s unit</label>
                <select id="calc-s-unit" name="s-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:uat,uvt,uva,sut,suv,sua">
            <x-calc.field name="u" label="Initial velocity u" value="0" placeholder="Initial velocity u">
                <label for="calc-u-unit" class="sr-only">Initial velocity u unit</label>
                <select id="calc-u-unit" name="u-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:uvt,uva,vat,svt,suv,sva">
            <x-calc.field name="v" label="Final velocity v" value="20" placeholder="Final velocity v">
                <label for="calc-v-unit" class="sr-only">Final velocity v unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:uat,uva,vat,sua,sva,sat">
            <x-calc.field name="a" label="Acceleration a" value="2" placeholder="Acceleration a">
                <label for="calc-a-unit" class="sr-only">Acceleration a unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="known:uat,uvt,vat,sut,svt,sat">
            <x-calc.field name="t" label="Time t" value="10" placeholder="Time t">
                <label for="calc-t-unit" class="sr-only">Time t unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
    </div>

    <x-calc.result label="Displacement s" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'm', 'known' => 'uat', 's' => 100, 's-unit' => 'm', 'u' => 0, 'u-unit' => 'ms', 'v' => 20, 'v-unit' => 'ms', 'a' => 2, 'a-unit' => 'ms2', 't' => 10, 't-unit' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            's' => ['label' => 'Displacement s'],
            'u' => ['label' => 'Initial velocity u'],
            'v' => ['label' => 'Final velocity v'],
            'a' => ['label' => 'Acceleration a'],
            't' => ['label' => 'Time t'],
            'avg' => ['label' => 'Average velocity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
