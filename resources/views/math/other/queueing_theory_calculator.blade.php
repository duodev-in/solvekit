<x-calc.page
    title="Queueing Theory Calculator - SolveKit"
    description="Free queueing theory calculator: M/M/1 and M/M/c queues, with utilisation, the Erlang C waiting probability, queue length and waiting times."
    lede="Analyse a queue."
    about="With Poisson arrivals at rate λ and exponential service at rate μ per server, a queue with c servers is stable when ρ = λ/(cμ) < 1. Erlang C gives the chance of having to wait; Little's law L = λW links lengths and times. Waits grow sharply as ρ approaches 1. Also known as M/M/1 queue calculator and Erlang C calculator."
    :calc="['engine' => 'mt-other', 'tool' => 'queue', 'fields' => ['lambda', 'mu', 'servers']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => '10 customers an hour, 3 servers each handling 4 an hour: how long is the wait?', 'answer' => '0.3511235955 hours on average.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="lambda" label="Arrival rate λ (per unit time)" value="10" min="0" step="any" />
        <x-calc.field name="mu" label="Service rate μ per server" value="4" min="0" step="any" />
        <x-calc.field name="servers" label="Servers c" value="3" min="1" max="500" step="1" />
    </div>

    <x-calc.result label="Average wait in the queue" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lambda' => 10, 'mu' => 4, 'servers' => 3],
        'Single' => ['lambda' => 3, 'mu' => 4, 'servers' => 1],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rho' => ['label' => 'Utilisation ρ'],
            'pwait' => ['label' => 'Chance of waiting'],
            'lq' => ['label' => 'Average queue length Lq'],
            'l' => ['label' => 'Average number in the system L'],
            'wq' => ['label' => 'Average wait Wq'],
            'w' => ['label' => 'Average time in the system W'],
            'p0' => ['label' => 'Chance the system is empty P₀'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ρ = λ ÷ cμ</li>
            <li>L = λW</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
