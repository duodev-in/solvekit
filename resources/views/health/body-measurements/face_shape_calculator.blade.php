<x-calc.page
    title="Face Shape Calculator - SolveKit"
    description="Free face shape calculator: oval, round, square, rectangle, heart, diamond or oblong from four face measurements."
    lede="Find your face shape."
    about="Measure face length (hairline to chin) and the width of the forehead, cheekbones and jaw. Stylists compare the length with the cheekbone width and the three widths with each other; this follows those common rules, which are a convention rather than a standard. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-body', 'tool' => 'face_shape', 'fields' => ['length', 'forehead', 'cheek', 'jaw'], 'unitFields' => ['length' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'forehead' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'cheek' => collect(config('units.length'))->only(['cm', 'in'])->all(), 'jaw' => collect(config('units.length'))->only(['cm', 'in'])->all()]]"
    :how-to="[
        ['name' => 'Measure four distances', 'text' => 'With a soft tape or ruler in a mirror.'],
    ]"
    :faqs="[
        ['question' => 'What shape is 19 × 14 cm with a narrower jaw?', 'answer' => 'Oval.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="length" label="Face length" value="19" min="0" placeholder="Face length">
            <label for="calc-length-unit" class="sr-only">Face length unit</label>
            <select id="calc-length-unit" name="length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="forehead" label="Forehead width" value="13" min="0" placeholder="Forehead width">
            <label for="calc-forehead-unit" class="sr-only">Forehead width unit</label>
            <select id="calc-forehead-unit" name="forehead-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cheek" label="Cheekbone width" value="14" min="0" placeholder="Cheekbone width">
            <label for="calc-cheek-unit" class="sr-only">Cheekbone width unit</label>
            <select id="calc-cheek-unit" name="cheek-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="jaw" label="Jaw width" value="12" min="0" placeholder="Jaw width">
            <label for="calc-jaw-unit" class="sr-only">Jaw width unit</label>
            <select id="calc-jaw-unit" name="jaw-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['cm', 'in']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Face shape" />

    <x-calc.options :decimals="false" :examples="[
        'Oval' => ['length' => 19, 'length-unit' => 'cm', 'forehead' => 13, 'forehead-unit' => 'cm', 'cheek' => 14, 'cheek-unit' => 'cm', 'jaw' => 12, 'jaw-unit' => 'cm'],
        'Square' => ['length' => 17, 'length-unit' => 'cm', 'forehead' => 14, 'forehead-unit' => 'cm', 'cheek' => 14.2, 'cheek-unit' => 'cm', 'jaw' => 13.8, 'jaw-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'ratio' => ['label' => 'Length ÷ cheekbones'],
            'widths' => ['label' => 'Widths'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>length ÷ cheekbone width and width comparisons</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
