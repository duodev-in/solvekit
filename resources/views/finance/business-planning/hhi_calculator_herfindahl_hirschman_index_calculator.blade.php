<x-calc.page
    title="HHI Calculator (Herfindahl-Hirschman Index Calculator) - SolveKit"
    description="Free HHI calculator: Herfindahl-Hirschman Index of market concentration from market shares, with the 2023 DOJ/FTC Merger Guidelines thresholds and a merger check."
    lede="Measure market concentration with the HHI."
    about="HHI = Σ (market share in %)². It ranges from near 0 (many small firms) to 10,000 (monopoly). The 2023 Merger Guidelines treat markets over 1,800 as highly concentrated, and a merger raising HHI by more than 100 in such a market as presumptively anticompetitive. A merger of firms with shares a and b raises HHI by 2ab. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-biz', 'tool' => 'hhi', 'fields' => ['shares']]"
    :how-to="[
        ['name' => 'Enter market shares', 'text' => ''],
        ['name' => 'Read the HHI', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the HHI of shares 30, 25, 20, 15, 10?', 'answer' => '2,250: Highly concentrated (over 1,800, 2023 Merger Guidelines).'],
        ['question' => 'What if the top two merge?', 'answer' => 'Merging the first two: 3,750 (+1,500, presumed to lessen competition).'],
    ]"
>
    <x-calc.textarea name="shares" label="Market shares in % (largest first; the first two are merged in the check)" value="30, 25, 20, 15, 10" rows="2" />

    <x-calc.result label="Herfindahl-Hirschman Index" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['shares' => '30, 25, 20, 15, 10'],
        'Fragmented' => ['shares' => '8, 7, 6, 6, 5, 5, 5, 4, 4, 4, 3, 3'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Shares total'],
            'firms' => ['label' => 'Firms'],
            'equivalent' => ['label' => 'Equivalent equal-sized firms'],
            'merger' => ['label' => 'If the first two merge'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>HHI = Σ sᵢ²</li>
            <li>merger change = 2 s₁ s₂</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
