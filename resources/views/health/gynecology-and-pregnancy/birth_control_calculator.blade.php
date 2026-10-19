<x-calc.page
    title="Birth Control Calculator - SolveKit"
    description="Free birth control calculator: the chance of pregnancy with each contraceptive method in typical and perfect use, over one or more years."
    lede="Compare birth control failure rates."
    about="Typical use counts real-life mistakes such as missed pills; perfect use is when the method is always used correctly. Trussell's figures (Contraception 2011) give the percentage of US women with an unintended pregnancy in the first year. Long-acting methods (implant, IUDs) and sterilisation are over 99% effective in both. Over several years the chance builds up: 1 − (1 − p)ⁿ. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'birth_control', 'fields' => ['method', 'years']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => ''],
        ['name' => 'Enter the years of use', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How likely is pregnancy in a year using condoms?', 'answer' => '18% typical use, 2% in the first year perfect use.'],
        ['question' => 'And the pill over 5 years?', 'answer' => '37.6% typical, 1.5% perfect over 5 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="method" label="Method" :options="['condom' => 'Male condom', 'pill' => 'Pill (combined or progestin-only)', 'patch' => 'Patch', 'ring' => 'Vaginal ring', 'injection' => 'Injection (Depo-Provera)', 'copper' => 'Copper IUD', 'lng' => 'Hormonal IUD (levonorgestrel)', 'implant' => 'Implant', 'diaphragm' => 'Diaphragm', 'female_condom' => 'Female condom', 'sponge' => 'Sponge (never given birth)', 'spermicide' => 'Spermicides', 'withdrawal' => 'Withdrawal', 'fam' => 'Fertility awareness methods', 'tubal' => 'Female sterilisation', 'vasectomy' => 'Vasectomy', 'none' => 'No method']" selected="condom" />
        <x-calc.field name="years" label="Years of use" value="1" min="1" max="30" step="1" suffix="years" />
    </div>

    <x-calc.result label="Chance of pregnancy in the first year" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['method' => 'condom', 'years' => 1],
        'Pill 5 years' => ['method' => 'pill', 'years' => 5],
        'IUD' => ['method' => 'copper', 'years' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'perfect' => ['label' => 'Perfect use'],
            'years' => ['label' => 'Over the years'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="All methods" name="methods" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P(n years) = 1 − (1 − p)ⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
