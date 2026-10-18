<x-calc.page
    title="Cryptocurrency Footprint Calculator - SolveKit"
    description="Free cryptocurrency footprint calculator: Bitcoin network electricity from hashrate and miner efficiency, energy and CO₂ per transaction."
    lede="Work out the energy and CO₂ of the Bitcoin network and per transaction."
    about="Network power = hashrate × energy per hash. With every miner as efficient as a given model, this gives a lower bound; older machines use more. The defaults are the network hashrate (mempool.space) and average transactions per day (blockchain.com) on 18 October 2026, and Bitmain's published efficiencies. Mining energy does not grow with the number of transactions; dividing it by transactions is an allocation used for comparison."
    :calc="['engine' => 'eco-footprint', 'tool' => 'crypto', 'fields' => ['hashrate', 'tx', 'miner', 'jth', 'overhead', 'yours', 'grid', 'grid_custom'], 'data' => collect(config('ecology_data'))->only(['grid', 'dated'])->all()]"
    :how-to="[
        ['name' => 'Check the network figures', 'text' => 'Update the hashrate and transactions if you have newer ones.'],
        ['name' => 'Choose the miner efficiency', 'text' => 'And the grid that powers mining.'],
    ]"
    :faqs="[
        ['question' => 'How much electricity does Bitcoin use?', 'answer' => 'About 150 TWh a year if every miner were as efficient as an Antminer S21 at today\'s hashrate; more with older machines.'],
        ['question' => 'Why is per-transaction energy misleading?', 'answer' => 'Miners use the same power whether blocks are full or not.'],
        ['question' => 'Where does the hashrate come from?', 'answer' => 'Public blockchain data, such as mempool.space.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hashrate" label="Network hashrate" value="1018.8" min="0" suffix="EH/s" />
        <x-calc.field name="tx" label="Transactions per day" value="559820" min="1" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="miner" label="Miner efficiency" :options="collect(config('ecology_data.dated.miners'))->map(fn ($m) => $m['name'])->all() + ['custom' => 'My own (J/TH)']" selected="s21" />
        <div data-show-when="miner:custom" hidden>
            <x-calc.field name="jth" label="Efficiency" value="25" min="0" suffix="J/TH" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="overhead" label="Cooling and other overhead" value="0" min="0" suffix="%" />
        <x-calc.field name="yours" label="Your transactions a year (optional)" value="" min="0" step="1" placeholder="Optional" />
    </div>

    <x-calc.select name="grid" label="Electricity grid" :options="['OWID_WRL' => 'World average'] + collect(config('ecology_data.grid'))->except('OWID_WRL')->sortBy('name')->map(fn ($g) => $g['name'])->all() + ['custom' => 'My own value (g/kWh)']" selected="OWID_WRL" />

    <div data-show-when="grid:custom" hidden>
        <x-calc.field name="grid_custom" label="Grid intensity" value="400" min="0" suffix="g CO₂e/kWh" />
    </div>

    <x-calc.result label="Energy per Bitcoin transaction (allocated)" />

    <x-calc.options :examples="[
        'S21 fleet, world grid' => ['hashrate' => 1018.8, 'tx' => 559820, 'miner' => 's21', 'overhead' => 0, 'grid' => 'OWID_WRL'],
        'Older S19 fleet' => ['hashrate' => 1018.8, 'tx' => 559820, 'miner' => 's19', 'overhead' => 5, 'grid' => 'USA'],
        'My 50 transactions a year' => ['hashrate' => 1018.8, 'tx' => 559820, 'miner' => 's21pro', 'overhead' => 0, 'grid' => 'OWID_WRL', 'yours' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'network' => ['label' => 'Network'],
            'co2' => ['label' => 'CO₂ per transaction'],
            'yours' => ['label' => 'Your use'],
            'note' => ['label' => 'Note'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>power = hashrate (H/s) × J/TH ÷ 10¹²</li>
            <li>per transaction = yearly kWh ÷ (transactions per day × 365)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
