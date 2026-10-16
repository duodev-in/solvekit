<x-calc.page
    title="Dog Life Expectancy Calculator - SolveKit"
    description="Free dog life expectancy calculator: typical lifespan by breed or, for mixed breeds, by adult weight."
    lede="Look up how long your dog is likely to live by breed or size."
    about="Breed ranges are the typical lifespans in American Kennel Club breed profiles. For mixed breeds the range comes from adult weight: small dogs often live 12 to 16 years and giant dogs 7 to 10. Individual dogs vary widely with genetics, weight and care."
    :calc="['engine' => 'pets', 'tool' => 'dog_lifespan', 'fields' => ['breed', 'weight', 'age'], 'unitFields' => ['weight' => collect(config('units.mass'))->only(['lb', 'kg'])->all()], 'data' => config('biology_data.dog_breeds')]"
    :how-to="[
        ['name' => 'Pick the breed', 'text' => 'Or mixed breed and enter the adult weight.'],
        ['name' => 'Add the age', 'text' => 'To see the years ahead.'],
    ]"
    :faqs="[
        ['question' => 'Which dogs live longest?', 'answer' => 'Small breeds such as Chihuahuas and Dachshunds often reach 14 to 16.'],
        ['question' => 'Why do big dogs die younger?', 'answer' => 'Large and giant breeds age faster and have more cancer and joint disease.'],
        ['question' => 'Do mixed breeds live longer?', 'answer' => 'Often slightly, but size matters more than mixing.'],
    ]"
>
    <x-calc.select name="breed" label="Breed" :options="collect(config('biology_data.dog_breeds'))->map(fn ($item) => $item['name'])->prepend('Mixed breed (use weight)', 'mixed')->all()" selected="labrador" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="breed:mixed" hidden>
            <x-calc.field name="weight" label="Adult weight" value="40" min="0" placeholder="Adult weight">
                <label for="calc-weight-unit" class="sr-only">Adult weight unit</label>
                <select id="calc-weight-unit" name="weight-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="age" label="Current age (optional)" value="4" min="0" suffix="years" placeholder="Optional" />
    </div>

    <x-calc.result label="Typical life expectancy" />

    <x-calc.options :examples="[
        'Labrador, 4 years' => ['breed' => 'labrador', 'age' => 4],
        'Great Dane, 6 years' => ['breed' => 'great_dane', 'age' => 6],
        'Mixed 25 lb' => ['breed' => 'mixed', 'weight' => 25, 'weight-unit' => 'lb', 'age' => 3],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'middle' => ['label' => 'Middle of the range'],
            'remaining' => ['label' => 'Years to go'],
            'note' => ['label' => 'Keep in mind'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>breeds: AKC typical range</li>
            <li>mixed: small 12–16, medium 10–14, large 10–12, giant 7–10 years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
