<x-calc.page
    title="VAT Calculator - SolveKit"
    description="Free VAT calculator: add or remove value added tax at the standard rate of the UK, EU countries and others, or any rate you enter."
    lede="Add or remove VAT."
    about="Adding VAT: gross = net × (1 + rate). Removing VAT from a gross price: net = gross ÷ (1 + rate), so at 20% VAT is 1/6 of the gross. Standard rates: UK 20%, Germany 19%, France 20%, Ireland 23%, Hungary 27% (the EU's highest); many goods carry reduced rates. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-tax', 'tool' => 'vat', 'fields' => ['mode', 'amount', 'country', 'rate'], 'currency' => 'GBP']"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the rate', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is £100 plus 20% VAT?', 'answer' => '£120.00.'],
        ['question' => 'How much VAT is in £120?', 'answer' => '£20.00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Calculate" :options="['add' => 'Add VAT', 'remove' => 'Remove VAT']" selected="add" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="amount" label="Amount" value="100" step="0.01" suffix="$" />
        <x-calc.select name="country" label="Rate" :options="['gb' => 'United Kingdom 20%', 'de' => 'Germany 19%', 'fr' => 'France 20%', 'it' => 'Italy 22%', 'es' => 'Spain 21%', 'nl' => 'Netherlands 21%', 'ie' => 'Ireland 23%', 'be' => 'Belgium 21%', 'at' => 'Austria 20%', 'pl' => 'Poland 23%', 'se' => 'Sweden 25%', 'dk' => 'Denmark 25%', 'fi' => 'Finland 25.5%', 'pt' => 'Portugal 23%', 'gr' => 'Greece 24%', 'hu' => 'Hungary 27%', 'cz' => 'Czechia 21%', 'ch' => 'Switzerland 8.1%', 'no' => 'Norway 25%', 'ae' => 'UAE 5%', 'sa' => 'Saudi Arabia 15%', 'za' => 'South Africa 15%', 'au' => 'Australia GST 10%', 'nz' => 'New Zealand GST 15%', 'jp' => 'Japan 10%', 'sg' => 'Singapore GST 9%', 'custom' => 'Other rate']" selected="gb" />
        <x-calc.field name="rate" label="Other rate" value="20" step="any" suffix="%" />
    </div>

    <x-calc.result label="Gross amount (including VAT)" />

    <x-calc.options :decimals="false" :examples="[
        'Add UK' => ['mode' => 'add', 'amount' => 100, 'country' => 'gb', 'rate' => 20],
        'Remove UK' => ['mode' => 'remove', 'amount' => 120, 'country' => 'gb', 'rate' => 20],
        'Germany' => ['mode' => 'add', 'amount' => 250, 'country' => 'de', 'rate' => 19],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'vat' => ['label' => 'VAT'],
            'net' => ['label' => 'Net'],
            'gross' => ['label' => 'Gross'],
            'fraction' => ['label' => 'VAT fraction'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>gross = net × (1 + r)</li>
            <li>net = gross ÷ (1 + r)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
