<x-calc.page
    title="Smartphone Projector Calculator - SolveKit"
    description="Free smartphone projector calculator: picture size and phone position for a DIY lens projector."
    lede="Design a phone projector."
    about="A magnifying lens in a shoebox projects a phone screen onto a wall. The thin lens equation sets where the phone goes and how big the picture is."
    :calc="['engine' => 'ph-quantum', 'tool' => 'phone_projector', 'fields' => ['f', 'diag', 'wall', 'out'], 'unitFields' => ['f' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'diag' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'wall' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'How big a picture does a 100 mm lens make 2 m away?', 'answer' => '115.9 in.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="f" label="Lens focal length" value="100" placeholder="Lens focal length">
            <label for="calc-f-unit" class="sr-only">Lens focal length unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="diag" label="Phone screen diagonal" value="6.1" placeholder="Phone screen diagonal">
            <label for="calc-diag-unit" class="sr-only">Phone screen diagonal unit</label>
            <select id="calc-diag-unit" name="diag-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="wall" label="Lens to wall distance" value="2" placeholder="Lens to wall distance">
            <label for="calc-wall-unit" class="sr-only">Lens to wall distance unit</label>
            <select id="calc-wall-unit" name="wall-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="in" />
    </div>

    <x-calc.result label="Picture diagonal on the wall" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'in', 'f' => 100, 'f-unit' => 'mm', 'diag' => 6.1, 'diag-unit' => 'in', 'wall' => 2, 'wall-unit' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'phone' => ['label' => 'Phone to lens distance'],
            'm' => ['label' => 'Magnification'],
            'bright' => ['label' => 'Brightness'],
            'flip' => ['label' => 'Orientation'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
