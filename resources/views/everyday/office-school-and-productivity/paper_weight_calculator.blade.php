<x-calc.page
    title="Paper Weight Calculator - SolveKit"
    description="Free paper weight calculator: convert GSM to pounds and back for bond, text, cover, index and other US paper grades, which use different basis sizes."
    lede="Convert paper weight between GSM and pounds."
    about="US paper weight is the weight of 500 sheets at the grade's basis size: bond 17 × 22 in, text 25 × 38 in, cover 20 × 26 in, index 25.5 × 30.5 in. So the same paper is 20 lb bond and 50 lb text (about 75 GSM). GSM (grams per square meter) is the same for every grade."
    :calc="['engine' => 'ev-office', 'tool' => 'paper_weight', 'fields' => ['direction', 'gsm', 'pounds', 'grade'], 'data' => ['paper_grades' => config('everyday_data.paper_grades')]]"
    :how-to="[
        ['name' => 'Choose the direction', 'text' => 'And enter the weight.'],
        ['name' => 'Pick the grade', 'text' => 'It sets the basis size.'],
    ]"
    :faqs="[
        ['question' => 'What is 20 lb bond in GSM?', 'answer' => 'About 75 GSM.'],
        ['question' => 'What is 80 lb cover in GSM?', 'answer' => 'About 216 GSM.'],
        ['question' => 'Why is 20 lb bond the same as 50 lb text?', 'answer' => 'The text basis sheet is bigger.'],
    ]"
>
    <x-calc.segmented name="direction" legend="Convert" :options="['from_gsm' => 'GSM → pounds', 'from_lb' => 'Pounds → GSM']" selected="from_gsm" />

    <div data-show-when="direction:from_gsm">
        <x-calc.field name="gsm" label="Paper weight" value="75" min="1" suffix="GSM" />
    </div>

    <div data-show-when="direction:from_lb" hidden>
        <x-calc.field name="pounds" label="Basis weight" value="20" min="1" suffix="lb" />
    </div>

    <x-calc.select name="grade" label="Grade" :options="collect(config('everyday_data.paper_grades'))->map(fn ($g) => $g[0].' ('.$g[1].' × '.$g[2].' in)')->all()" selected="bond" />

    <x-calc.result label="Basis weight" />

    <x-calc.options :examples="[
        '75 GSM' => ['direction' => 'from_gsm', 'gsm' => 75, 'pounds' => '', 'grade' => 'bond'],
        '80 lb cover' => ['direction' => 'from_lb', 'gsm' => '', 'pounds' => 80, 'grade' => 'cover'],
        '100 lb text' => ['direction' => 'from_lb', 'gsm' => '', 'pounds' => 100, 'grade' => 'text'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sheet' => ['label' => 'Sheet weight'],
        ]" />
        <x-calc.quick-ref heading="In every grade" name="grades" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lb = GSM × basis area (m²) × 500 ÷ 453.59</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
