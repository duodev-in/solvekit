<x-calc.page
    title="Books vs e-Books Calculator - SolveKit"
    description="Free books vs e-books calculator: how many paper books it takes to match an e-reader's carbon footprint, from Amazon's certified e-reader footprints and the DESNZ paper factor."
    lede="Work out when an e-reader becomes lower carbon than paper books."
    about="Amazon publishes certified life cycle footprints for its e-readers: 35 kg CO₂e for a Kindle Paperwhite (12th generation), over 95% of it from making the device. A paper book's footprint here is the paper it is printed on, using the DESNZ 2025 factor for making paper (1.345 kg CO₂e per kg); printing, transport and shops add more, so the true break-even comes sooner."
    :calc="['engine' => 'eco-living', 'tool' => 'books', 'fields' => ['books', 'book_g', 'reader', 'reader_kg', 'years'], 'unitFields' => ['book_g' => collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg'])->all()], 'data' => collect(config('ecology_data'))->only(['ereaders', 'materials'])->all()]"
    :how-to="[
        ['name' => 'Enter books per year and weight', 'text' => 'A 300-page paperback is about 300–400 g.'],
        ['name' => 'Choose the e-reader', 'text' => 'Or enter its published footprint.'],
    ]"
    :faqs="[
        ['question' => 'Are e-readers better for the environment?', 'answer' => 'For carbon, yes if you read enough books: about 66 books of 400 g match a Kindle Paperwhite on paper alone.'],
        ['question' => 'What about library books?', 'answer' => 'Shared books spread their footprint over many readers.'],
        ['question' => 'Does charging matter?', 'answer' => 'Under 1% of an e-reader\'s life cycle footprint (Amazon).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="books" label="Books you read a year" value="12" min="0.1" step="1" />
        <x-calc.field name="book_g" label="Weight of a book" value="400" min="0" placeholder="Weight of a book">
            <label for="calc-book_g-unit" class="sr-only">Weight of a book unit</label>
            <select id="calc-book_g-unit" name="book_g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['g', 'oz', 'lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'g')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="reader" label="E-reader" :options="collect(config('ecology_data.ereaders'))->map(fn ($e) => $e['name'].' ('.$e['kg'].' kg CO₂e)')->all() + ['custom' => 'Another device']" selected="paperwhite_12" />
        <div data-show-when="reader:custom" hidden>
            <x-calc.field name="reader_kg" label="Device footprint" value="60" min="0" suffix="kg CO₂e" />
        </div>
    </div>

    <x-calc.field name="years" label="Years you will use the e-reader" value="5" min="1" step="1" />

    <x-calc.result label="Books before the e-reader is lower carbon" />

    <x-calc.options :examples="[
        '12 books a year, Paperwhite' => ['books' => 12, 'book_g' => 400, 'book_g-unit' => 'g', 'reader' => 'paperwhite_12', 'years' => 5],
        'Heavy reader, 50 a year' => ['books' => 50, 'book_g' => 350, 'book_g-unit' => 'g', 'reader' => 'paperwhite_12', 'years' => 4],
        'Hardbacks, Kindle Scribe' => ['books' => 10, 'book_g' => 1.2, 'book_g-unit' => 'lb', 'reader' => 'scribe', 'years' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'years' => ['label' => 'Time to break even'],
            'paper' => ['label' => 'Paper books'],
            'reader' => ['label' => 'E-reader'],
            'scope' => ['label' => 'Scope'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>book = kg of paper × 1.345 kg CO₂e per kg</li>
            <li>break-even = device kg ÷ book kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
