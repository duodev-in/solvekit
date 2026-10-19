<x-calc.page
    title="NPS Calculator - SolveKit"
    description="Free NPS Calculator: NPS = % promoters − % detractors. Net Promoter Score (Bain & Company) ranges from −100 to +100."
    lede="Work out the Net Promoter Score from promoters (9–10), passives (7–8) and detractors (0–6)."
    about="Net Promoter Score (Bain & Company) ranges from −100 to +100. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'net_promoter_score', 'fields' => ['promoters', 'passives', 'detractors']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Promoters (9–10), Passives (7–8), Detractors (0–6).'],
        ['name' => 'Read the result', 'text' => 'The Net Promoter Score appears as you type, with responses below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the Net Promoter Score?', 'answer' => 'NPS = % promoters − % detractors.'],
        ['question' => 'What is the Net Promoter Score for promoters 60, passives 25, detractors 15?', 'answer' => '45. Responses: 100.'],
        ['question' => 'And for promoters 120, passives 90, detractors 70?', 'answer' => '17.86. Responses: 280.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 0 is positive; above 50 is excellent.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="promoters" label="Promoters (9–10)" value="60" min="0" step="1" />
        <x-calc.field name="passives" label="Passives (7–8)" value="25" min="0" step="1" />
        <x-calc.field name="detractors" label="Detractors (0–6)" value="15" min="0" step="1" />
    </div>

    <x-calc.result label="Net Promoter Score" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['promoters' => 60, 'passives' => 25, 'detractors' => 15],
        'Example B' => ['promoters' => 120, 'passives' => 90, 'detractors' => 70],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Responses'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>NPS = % promoters − % detractors</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
