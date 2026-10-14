<x-tool-page-layout
    title="Mbps to Gbps Converter - SolveKit"
    description="Professional Mbps to Gbps converter for network speeds. Convert between megabits and gigabits per second with detailed analysis and network performance insights."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Mbps to Gbps Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer bg-purple-50 border-purple-300">
                                                                                        <input type="radio" name="mode" value="mbps-to-gbps" class="text-purple-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Mbps → Gbps</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="gbps-to-mbps" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Gbps → Mbps</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    Enter Speed in Mbps
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter speed (e.g., 1000)"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">Mbps</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHelp">Enter network speed value</p>
                                                                            </div>





                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Gigabits per Second (Gbps)</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted to gigabits per second</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-purple-600 hover:text-purple-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Speed Comparison -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Mbps -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Megabits per Second</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="mbpsDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁶ bits/second</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Gbps -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Gigabits per Second</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="gbpsDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁹ bits/second</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Speed Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Speed Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="1000" data-mode="mbps-to-gbps">1000 Mbps</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="10000" data-mode="mbps-to-gbps">10 Gbps</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="2.5" data-mode="gbps-to-mbps">2.5 Gbps</button>
                                                            <button type="button" class="speed-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="100" data-mode="gbps-to-mbps">100 Gbps</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Speed Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Network Speed Reference</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Gbps</strong> = 1,000 Mbps</div>
                                                        <div><strong>10 Gbps</strong> = 10,000 Mbps</div>
                                                        <div><strong>100 Gbps</strong> = 100,000 Mbps</div>
                                                        <div><strong>1 Tbps</strong> = 1,000,000 Mbps</div>
                                                        <div>Fast Ethernet: 100 Mbps</div>
                                                        <div>Gigabit Ethernet: 1 Gbps</div>
                                                        <div>10-Gigabit Ethernet: 10 Gbps</div>
                                                        <div>100-Gigabit Ethernet: 100 Gbps</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const inputValue = document.getElementById('inputValue');
                            const modeRadios = document.getElementsByName('mode');
                            const clearButton = document.getElementById('clearButton');
                            const inputLabel = document.getElementById('inputLabel');
                            const inputUnit = document.getElementById('inputUnit');
                            const inputHelp = document.getElementById('inputHelp');

                            // Output elements
                            const output = document.getElementById('output');
                            const resultTitle = document.getElementById('result-title');
                            const resultDescription = document.getElementById('result-description');
                            const mbpsDisplay = document.getElementById('mbpsDisplay');
                            const gbpsDisplay = document.getElementById('gbpsDisplay');
                            const copyResult = document.getElementById('copyResult');

                            function getMode() {
                                const checked = document.querySelector('input[name="mode"]:checked');
                                return checked ? checked.value : 'mbps-to-gbps';
                            }

                            function formatNumber(num) {
                                if (!Number.isFinite(num)) {
                                    return '--';
                                }

                                const abs = Math.abs(num);

                                if (abs === 0) {
                                    return '0';
                                }

                                if (abs >= 1e15 || abs < 1e-6) {
                                    return num.toExponential(6).replace(/\.?0+e/, 'e');
                                }

                                if (abs >= 1) {
                                    return num.toLocaleString('en-US', { maximumFractionDigits: 6 });
                                }

                                return num.toLocaleString('en-US', { maximumSignificantDigits: 6 });
                            }

                            function updateInterface() {
                                if (getMode() === 'mbps-to-gbps') {
                                    inputLabel.textContent = 'Enter Speed in Mbps';
                                    inputUnit.textContent = 'Mbps';
                                    inputHelp.textContent = 'Enter megabits per second';
                                    resultTitle.textContent = 'Gigabits per Second (Gbps)';
                                    inputValue.placeholder = 'Enter Mbps (e.g., 1000)';
                                } else {
                                    inputLabel.textContent = 'Enter Speed in Gbps';
                                    inputUnit.textContent = 'Gbps';
                                    inputHelp.textContent = 'Enter gigabits per second';
                                    resultTitle.textContent = 'Megabits per Second (Mbps)';
                                    inputValue.placeholder = 'Enter Gbps (e.g., 1)';
                                }
                            }

                            function convert() {
                                const inputVal = parseFloat(inputValue.value);
                                const mode = getMode();
                                const divisor = 1000;

                                if (Number.isNaN(inputVal) || inputVal < 0) {
                                    clearOutputs();
                                    return;
                                }

                                const mbps = mode === 'mbps-to-gbps' ? inputVal : inputVal * divisor;
                                const gbps = mode === 'mbps-to-gbps' ? inputVal / divisor : inputVal;

                                output.textContent = mode === 'mbps-to-gbps' ? `${formatNumber(gbps)} Gbps` : `${formatNumber(mbps)} Mbps`;
                                resultDescription.textContent = mode === 'mbps-to-gbps'
                                    ? `${formatNumber(inputVal)} Mbps = ${formatNumber(gbps)} Gbps`
                                    : `${formatNumber(inputVal)} Gbps = ${formatNumber(mbps)} Mbps`;

                                mbpsDisplay.textContent = formatNumber(mbps);
                                gbpsDisplay.textContent = formatNumber(gbps);
                            }

                            function clearOutputs() {
                                output.textContent = '--';
                                resultDescription.textContent = getMode() === 'mbps-to-gbps' ? 'Converted to gigabits per second' : 'Converted to megabits per second';
                                mbpsDisplay.textContent = '--';
                                gbpsDisplay.textContent = '--';
                            }

                            function clearAll() {
                                inputValue.value = '';
                                document.querySelector('input[name="mode"][value="mbps-to-gbps"]').checked = true;
                                updateInterface();
                                clearOutputs();
                                inputValue.focus();
                            }

                            // Event listeners
                            inputValue.addEventListener('input', convert);

                            modeRadios.forEach(radio => {
                                radio.addEventListener('change', () => {
                                    updateInterface();
                                    convert();
                                });
                            });

                            // Quick speed examples
                            const speedExamples = document.querySelectorAll('.speed-example');
                            speedExamples.forEach(button => {
                                button.addEventListener('click', function() {
                                    const mode = this.getAttribute('data-mode');

                                    inputValue.value = this.getAttribute('data-value');
                                    document.querySelector(`input[name="mode"][value="${mode}"]`).checked = true;
                                    updateInterface();
                                    convert();

                                    speedExamples.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                    speedExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                    this.classList.remove('bg-gray-100', 'text-gray-700');
                                    this.classList.add('bg-purple-100', 'text-purple-700');
                                });
                            });

                            clearButton.addEventListener('click', clearAll);

                            // Copy functionality
                            copyResult.addEventListener('click', function() {
                                const text = output.textContent;
                                if (text !== '--') {
                                    navigator.clipboard.writeText(text).then(() => {
                                        this.textContent = 'Copied!';
                                        setTimeout(() => {
                                            this.textContent = 'Copy Result';
                                        }, 2000);
                                    });
                                }
                            });

                            // Initialize
                            updateInterface();
                            clearOutputs();
                            inputValue.focus();

                            // Keyboard shortcuts
                            document.addEventListener('keydown', function(e) {
                                if (e.key === 'Escape') {
                                    clearAll();
                                } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                    e.preventDefault();
                                    const newMode = getMode() === 'mbps-to-gbps' ? 'gbps-to-mbps' : 'mbps-to-gbps';
                                    document.querySelector(`input[name="mode"][value="${newMode}"]`).checked = true;
                                    updateInterface();
                                    convert();
                                }
                            });
                        });
                </script>
    </x-slot>
</x-tool-page-layout>
