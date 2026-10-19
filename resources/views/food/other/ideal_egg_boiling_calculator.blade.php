<x-calc.page
    title="Ideal Egg Boiling Calculator - SolveKit"
    description="Free ideal egg boiling calculator: the physics of a boiled egg. Time for the yolk to reach your chosen temperature from egg mass, starting temperature and altitude, with Charles Williams' formula."
    lede="Calculate egg boiling time from physics."
    about="Physicist Charles D. H. Williams modelled an egg as a sphere heated by conduction: t = M^⅔ c ρ^⅓ ÷ (K π² (4π/3)^⅔) × ln[0.76 (T_egg − T_water) ÷ (T_yolk − T_water)], with mass M in grams, specific heat c = 3.7 J/g·K, density ρ = 1.038 g/cm³ and conductivity K = 5.4 × 10⁻³ W/cm·K. A yolk at about 63 °C is runny, 70 °C just set and 77 °C firm. Water boils lower at altitude, which slows cooking. Real eggs may need a little longer than the model."
    :calc="['engine' => 'fd-other', 'tool' => 'ideal_egg', 'fields' => ['mass_mode', 'size', 'mass', 'egg_temp', 'altitude', 'yolk', 'yolk_custom'], 'unitFields' => ['egg_temp' => collect(config('units.temperature'))->only(['f', 'c'])->all(), 'altitude' => collect(config('units.length'))->only(['ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the egg size or mass', 'text' => ''],
        ['name' => 'Enter its temperature and your altitude', 'text' => ''],
        ['name' => 'Pick the yolk you want', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How long for a 57 g fridge-cold egg to a 63 °C yolk?', 'answer' => '4 min 32 s.'],
        ['question' => 'And a just-set yolk at 2,000 m?', 'answer' => '7 min 7 s.'],
    ]"
>
    <x-calc.segmented name="mass_mode" legend="Egg" :options="['size' => 'By size', 'mass' => 'By mass']" selected="size" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mass_mode:size">
            <x-calc.select name="size" label="Size" :options="['small' => 'Small', 'medium' => 'Medium', 'large' => 'Large', 'xl' => 'Extra large', 'jumbo' => 'Jumbo']" selected="large" />
        </div>
        <div data-show-when="mass_mode:mass" hidden>
            <x-calc.field name="mass" label="Mass (in shell)" value="57" min="0" step="any" suffix="g" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="egg_temp" label="Egg temperature" value="4" placeholder="Egg temperature">
            <label for="calc-egg_temp-unit" class="sr-only">Egg temperature unit</label>
            <select id="calc-egg_temp-unit" name="egg_temp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['f', 'c']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="altitude" label="Altitude" value="0" min="0" placeholder="Altitude">
            <label for="calc-altitude-unit" class="sr-only">Altitude unit</label>
            <select id="calc-altitude-unit" name="altitude-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="yolk" label="Yolk" :options="['63' => 'Runny (63 °C)', '67' => 'Jammy (67 °C)', '70' => 'Just set (70 °C)', '77' => 'Firm (77 °C)', 'custom' => 'Custom']" selected="70" />
        <div data-show-when="yolk:custom" hidden>
            <x-calc.field name="yolk_custom" label="Yolk temperature (°C)" value="65" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Boiling time (Williams model)" />

    <x-calc.options :decimals="false" :examples="[
        'Runny' => ['mass_mode' => 'mass', 'size' => 'large', 'mass' => 57, 'egg_temp' => 4, 'egg_temp-unit' => 'c', 'altitude' => 0, 'altitude-unit' => 'm', 'yolk' => '63', 'yolk_custom' => 65],
        'Set, 2,000 m' => ['mass_mode' => 'size', 'size' => 'large', 'mass' => 57, 'egg_temp' => 4, 'egg_temp-unit' => 'c', 'altitude' => 2000, 'altitude-unit' => 'm', 'yolk' => '70', 'yolk_custom' => 65],
        'Firm, room temp' => ['mass_mode' => 'size', 'size' => 'xl', 'mass' => 57, 'egg_temp' => 20, 'egg_temp-unit' => 'c', 'altitude' => 0, 'altitude-unit' => 'm', 'yolk' => '77', 'yolk_custom' => 65],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'water' => ['label' => 'Water temperature'],
            'yolk' => ['label' => 'Yolk'],
            'sensitivity' => ['label' => 'Egg size effect'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>t = M^⅔ c ρ^⅓ ÷ (K π² (4π/3)^⅔) × ln[0.76 (T₀ − Tw) ÷ (Ty − Tw)]</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
