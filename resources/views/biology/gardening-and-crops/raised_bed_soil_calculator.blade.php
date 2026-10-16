<x-calc.page
    title="Raised Bed Soil Calculator - SolveKit"
    description="Free raised bed soil calculator: soil volume for one or more raised beds and how much topsoil, compost and aeration to mix."
    lede="Work out how much soil mix fills your raised beds."
    about="Each bed holds length × width × depth. A common raised-bed mix is 60% topsoil, 30% compost and 10% aeration material such as perlite or coarse sand."
    :calc="['engine' => 'garden', 'tool' => 'raised_bed', 'fields' => ['beds', 'depth', 'length', 'width'], 'unitFields' => ['depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the beds', 'text' => 'How many beds and their inside length, width and depth.'],
        ['name' => 'Read the mix', 'text' => 'The total and the topsoil, compost and aeration split.'],
    ]"
    :faqs="[
        ['question' => 'How much soil fills a 4 × 8 ft bed?', 'answer' => 'At 12 inches deep it holds 32 ft³, about 1.2 cubic yards.'],
        ['question' => 'What soil mix is best for raised beds?', 'answer' => 'A common mix is 60% topsoil, 30% compost and 10% perlite or coarse sand.'],
        ['question' => 'Can I fill the bottom with something else?', 'answer' => 'In deep beds, logs or branches at the bottom reduce the soil needed; they settle as they rot.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="beds" label="Number of beds" value="2" min="1" step="1" />
        <x-calc.field name="depth" label="Depth" value="12" min="0" placeholder="Depth">
            <label for="calc-depth-unit" class="sr-only">Depth unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Length" value="8" min="0" placeholder="Length">
            <label for="calc-length-unit" class="sr-only">Length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="width" label="Width" value="4" min="0" placeholder="Width">
            <label for="calc-width-unit" class="sr-only">Width unit</label>
            <select id="calc-width-unit" name="width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Soil mix needed" />

    <x-calc.options :examples="[
        '4 × 8 ft, 12 in' => ['beds' => 1, 'length' => 8, 'width' => 4, 'depth' => 12],
        '3 beds 6 × 3 ft' => ['beds' => 3, 'length' => 6, 'width' => 3, 'depth' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Mix" :grow="true" :rows="[
            'yd3' => ['label' => 'Cubic yards', 'unit' => 'yd³'],
            'liters' => ['label' => 'Liters', 'unit' => 'L'],
            'topsoil' => ['label' => 'Topsoil (60%)'],
            'compost' => ['label' => 'Compost (30%)'],
            'aeration' => ['label' => 'Perlite or sand (10%)'],
            'bags' => ['label' => 'Bags'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>volume = beds × length × width × depth</li>
            <li>mix 60% topsoil, 30% compost, 10% aeration</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
