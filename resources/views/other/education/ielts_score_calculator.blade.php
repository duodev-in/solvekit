<x-calc.page
    title="IELTS Score Calculator - SolveKit"
    description="Free IELTS score calculator: overall band from the four skills, with raw-score conversion for Listening and Reading."
    lede="Find your IELTS overall band."
    about="The IELTS overall band is the average of Listening, Reading, Writing and Speaking, rounded to the nearest half band."
    :calc="['engine' => 'ot-edu', 'tool' => 'ielts', 'fields' => ['listening', 'reading', 'writing', 'speaking', 'raw', 'test'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'other' => collect(config('other_data'))->only(['ielts'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What overall band do 7, 6.5, 6 and 7 give?', 'answer' => '6.5 (average 6.625).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="listening" label="Listening band (or raw, see below)" value="7" min="0" step="any" />
        <x-calc.field name="reading" label="Reading band" value="6.5" min="0" step="any" />
        <x-calc.field name="writing" label="Writing band" value="6" min="0" step="any" />
        <x-calc.field name="speaking" label="Speaking band" value="7" min="0" step="any" />
        <x-calc.select name="raw" label="Listening and Reading entered as" :options="['band' => 'Band scores', 'raw' => 'Raw scores out of 40']" selected="band" />
        <div data-show-when="raw:raw">
            <x-calc.select name="test" label="Test (for raw Reading)" :options="['academic' => 'Academic', 'general' => 'General Training']" selected="academic" />
        </div>
    </div>

    <x-calc.result label="Overall band" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['listening' => 7, 'reading' => 6.5, 'writing' => 6, 'speaking' => 7, 'raw' => 'band', 'test' => 'academic'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'average' => ['label' => 'Exact average'],
            'bands' => ['label' => 'Bands used'],
            'level' => ['label' => 'Typical description'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
