<x-calc.page
    title="Stair Carpet Calculator - SolveKit"
    description="Free stair carpet calculator: carpet or runner for a staircase from the number of steps, tread, riser and nosing, with a landing."
    lede="Work out the carpet or runner for a staircase."
    about="Each step takes its tread depth plus its riser height plus the wrap around the nosing (about 1–2 in). Multiply by the steps and the width, and add a landing if there is one."
    :calc="['engine' => 'con-finish', 'tool' => 'stair_carpet', 'fields' => ['steps', 'width', 'tread', 'riser', 'nosing', 'landing_length', 'landing_width', 'price'], 'unitFields' => ['width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'tread' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'riser' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'nosing' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'landing_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'landing_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the steps', 'text' => 'Count, tread, riser and nosing.'],
        ['name' => 'Enter the width', 'text' => 'Of the carpet or runner.'],
    ]"
    :faqs="[
        ['question' => 'How much carpet for 13 stairs?', 'answer' => 'About 6.9 yd² for 36 in wide stairs with 10 in treads, 7½ in risers and 1½ in nosing.'],
        ['question' => 'How long a runner for 13 stairs?', 'answer' => 'About 20 ft.'],
        ['question' => 'What is the nosing?', 'answer' => 'The rounded front edge of the tread that the carpet wraps.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="steps" label="Number of steps" value="13" min="1" step="1" />
        <x-calc.field name="width" label="Carpet or runner width" value="36" min="0" placeholder="Carpet or runner width">
            <label for="calc-width-unit" class="sr-only">Carpet or runner width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="tread" label="Tread depth" value="10" min="0" placeholder="Tread depth">
            <label for="calc-tread-unit" class="sr-only">Tread depth unit</label>
            <select id="calc-tread-unit" name="tread-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="riser" label="Riser height" value="7.5" min="0" placeholder="Riser height">
            <label for="calc-riser-unit" class="sr-only">Riser height unit</label>
            <select id="calc-riser-unit" name="riser-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="nosing" label="Nosing wrap" value="1.5" min="0" placeholder="Nosing wrap">
            <label for="calc-nosing-unit" class="sr-only">Nosing wrap unit</label>
            <select id="calc-nosing-unit" name="nosing-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="landing_length" label="Landing length (optional)" value="" min="0" placeholder="None">
            <label for="calc-landing_length-unit" class="sr-only">Landing length (optional) unit</label>
            <select id="calc-landing_length-unit" name="landing_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="landing_width" label="Landing width" value="3" min="0" placeholder="Landing width">
            <label for="calc-landing_width-unit" class="sr-only">Landing width unit</label>
            <select id="calc-landing_width-unit" name="landing_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="price" label="Price per yd² (optional)" value="" min="0" step="0.01" suffix="$" placeholder="Optional" />
    </div>

    <x-calc.result label="Stair carpet" />

    <x-calc.options :examples="[
        '13 steps, 36 in' => ['steps' => 13, 'width' => 36, 'width-unit' => 'in', 'tread' => 10, 'tread-unit' => 'in', 'riser' => 7.5, 'riser-unit' => 'in', 'nosing' => 1.5, 'nosing-unit' => 'in'],
        'With a landing' => ['steps' => 14, 'width' => 36, 'width-unit' => 'in', 'tread' => 10, 'tread-unit' => 'in', 'riser' => 7.25, 'riser-unit' => 'in', 'nosing' => 1.5, 'nosing-unit' => 'in', 'landing_length' => 3, 'landing_length-unit' => 'ft', 'landing_width' => 3, 'landing_width-unit' => 'ft'],
        'Runner 70 cm' => ['steps' => 12, 'width' => 70, 'width-unit' => 'cm', 'tread' => 25, 'tread-unit' => 'cm', 'riser' => 18, 'riser-unit' => 'cm', 'nosing' => 4, 'nosing-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'runner' => ['label' => 'Runner length'],
            'ft2' => ['label' => 'Area'],
            'per_step' => ['label' => 'Per step'],
            'cost' => ['label' => 'Cost'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>per step = tread + riser + nosing</li>
            <li>area = steps × per step × width + landing</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
