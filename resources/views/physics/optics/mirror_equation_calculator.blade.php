<x-calc.page
    title="Mirror Equation Calculator - SolveKit"
    description="Free mirror equation calculator: image distance, focal length or object distance for concave and convex mirrors."
    lede="Solve 1/f = 1/dₒ + 1/dᵢ."
    about="A curved mirror forms an image where 1/f = 1/dₒ + 1/dᵢ. A concave mirror (f > 0) makes real images of distant objects; a convex mirror (f < 0) always makes small upright virtual images."
    :calc="['engine' => 'ph-wave', 'tool' => 'mirror', 'fields' => ['solve', 'f', 'o', 'i', 'out_f', 'out_o', 'out_i'], 'unitFields' => ['f' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'o' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'i' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'Where is the image of an object 30 cm from a 10 cm concave mirror?', 'answer' => '15 cm in front of it.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['f' => 'Focal length', 'o' => 'Object distance', 'i' => 'Image distance']" selected="i" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:o,i">
            <x-calc.field name="f" label="Focal length" value="10" placeholder="Focal length">
                <label for="calc-f-unit" class="sr-only">Focal length unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f,i">
            <x-calc.field name="o" label="Object distance" value="30" placeholder="Object distance">
                <label for="calc-o-unit" class="sr-only">Object distance unit</label>
                <select id="calc-o-unit" name="o-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f,o" hidden>
            <x-calc.field name="i" label="Image distance" value="15" placeholder="Image distance">
                <label for="calc-i-unit" class="sr-only">Image distance unit</label>
                <select id="calc-i-unit" name="i-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f" hidden>
            <x-calc.select name="out_f" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
        <div data-show-when="solve:o" hidden>
            <x-calc.select name="out_o" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
        <div data-show-when="solve:i">
            <x-calc.select name="out_i" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
    </div>

    <x-calc.result label="Image distance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'i', 'f' => 10, 'f-unit' => 'cm', 'out_f' => 'cm', 'o' => 30, 'o-unit' => 'cm', 'out_o' => 'cm', 'i' => 15, 'i-unit' => 'cm', 'out_i' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'm' => ['label' => 'Magnification'],
            'image' => ['label' => 'Image'],
            'power' => ['label' => 'Power'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1/f = 1/dₒ + 1/dᵢ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
