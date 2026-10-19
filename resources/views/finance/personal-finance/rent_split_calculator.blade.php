<x-calc.page
    title="Rent Split Calculator - SolveKit"
    description="Free rent split calculator: fair shares of rent for roommates by room size (with shared space split equally), by income or equally."
    lede="Split rent fairly between roommates."
    about="By room size: a share of the rent (often 30–40%) covers shared space and is split equally; the rest is split by bedroom area. By income: each pays in proportion to income. Equal: rent ÷ people. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-life', 'tool' => 'rent_split', 'fields' => ['people', 'rent', 'method', 'shared']]"
    :how-to="[
        ['name' => 'List roommates', 'text' => 'Room size and income.'],
        ['name' => 'Choose the split', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How should $3,300 split by room size?', 'answer' => 'Alex pays $1,302.63.'],
        ['question' => 'And by income?', 'answer' => 'Alex pays $1,357.71.'],
    ]"
>
    <x-calc.rows-editor name="people" label="Roommates" :columns="['name' => 'Name', 'size' => 'Room ft²', 'income' => 'Income']" :rows="[['Alex', 160, 72000], ['Sam', 120, 55000], ['Jordan', 100, 48000]]" :text="['name']" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="rent" label="Monthly rent" value="3300" step="0.01" suffix="$" />
        <x-calc.select name="method" label="Split by" :options="['size' => 'Room size', 'income' => 'Income', 'equal' => 'Equally']" selected="size" />
        <x-calc.field name="shared" label="Share for common space" value="30" step="any" suffix="%" />
    </div>

    <x-calc.result label="First roommate pays" />

    <x-calc.options :decimals="false" :examples="[
        'By size' => ['people' => 'Alex	160	72000
Sam	120	55000
Jordan	100	48000', 'rent' => 3300, 'method' => 'size', 'shared' => 30],
        'By income' => ['people' => 'Alex	160	72000
Sam	120	55000
Jordan	100	48000', 'rent' => 3300, 'method' => 'income', 'shared' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'equal' => ['label' => 'Equal share'],
            'total' => ['label' => 'Total rent'],
            'method' => ['label' => 'Method'],
            'people' => ['label' => 'Roommates'],
        ]" />
        <x-calc.quick-ref heading="Shares" name="shares" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>size: shared ÷ n + (1 − shared) × room ÷ Σ rooms</li>
            <li>income: income ÷ Σ incomes</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
