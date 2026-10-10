<x-tool-page-layout
    title="Billion to Trillion Converter - ConvertPro"
    description="Professional billion to trillion converter for finance and large number calculations. Convert between billions, trillions and other large denominations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Billion to Trillion</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer bg-yellow-50 border-yellow-300">
                                                                                        <input type="radio" name="mode" value="billion-to-trillion" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Billion → Trillion</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="trillion-to-billion" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Trillion → Billion</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    Enter Billions
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter value"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">Billion</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHelp">Enter the number of billions to convert</p>
                                                                            </div>

                                                                            <!-- Number System Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Number System
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="system" value="short" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Short Scale (US/UK)</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="system" value="long" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Long Scale (Europe)</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Precision Level -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Precision Level
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-yellow-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-yellow-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-yellow-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Trillions</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted value</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-yellow-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-yellow-600 hover:text-yellow-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- All Denominations -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Billions -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Billions</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="billionDisplay">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Trillions -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Trillions</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="trillionDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Denominations -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Millions -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Millions</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="millionDisplay">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Quadrillions -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Quadrillions</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="quadrillionDisplay">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Scientific Notation -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Scientific</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="scientificDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <span id="scaleSystem">Short Scale</span>
                                                                                <span id="digitCount">--</span>
                                                                                <span id="zeroCount">--</span>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Values -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Values
                                                        </label>
                                                        <div class="grid grid-cols-4 gap-2">
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="1">1</button>
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="10">10</button>
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="100">100</button>
                                                            <button type="button" class="quick-value px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-value="1000">1000</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Number Scale Reference</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 Billion = 1,000 Million</div>
                                                        <div>• 1 Trillion = 1,000 Billion</div>
                                                        <div>• 1 Quadrillion = 1,000 Trillion</div>
                                                        <div>• Short Scale: 10^9, 10^12, 10^15</div>
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
                        const systemRadios = document.getElementsByName('system');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const inputHelp = document.getElementById('inputHelp');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const billionDisplay = document.getElementById('billionDisplay');
                        const trillionDisplay = document.getElementById('trillionDisplay');
                        const millionDisplay = document.getElementById('millionDisplay');
                        const quadrillionDisplay = document.getElementById('quadrillionDisplay');
                        const scientificDisplay = document.getElementById('scientificDisplay');
                        const scaleSystem = document.getElementById('scaleSystem');
                        const digitCount = document.getElementById('digitCount');
                        const zeroCount = document.getElementById('zeroCount');
                        const copyResult = document.getElementById('copyResult');

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function getSystem() {
                            return document.querySelector('input[name="system"]:checked').value;
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }

                            const absolute = Math.abs(num);
                            if (absolute >= 1e21 || (absolute !== 0 && absolute < 1e-9)) {
                                return num.toExponential(4).replace(/\.?0+e/, 'e');
                            }

                            if (absolute !== 0 && absolute < 1) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }

                            const fractionDigits = precision === 'auto' ? 6 : precision;
                            return num.toLocaleString(undefined, { maximumFractionDigits: fractionDigits });
                        }

                        function updateInterface() {
                            const mode = getMode();
                            const system = getSystem();
                            
                            scaleSystem.textContent = system === 'short' ? 'Short Scale (US/UK)' : 'Long Scale (Europe)';
                            
                            if (mode === 'billion-to-trillion') {
                                inputLabel.textContent = 'Enter Billions';
                                inputUnit.textContent = 'Billion';
                                inputHelp.textContent = 'Enter the number of billions to convert';
                                resultTitle.textContent = 'Trillions';
                                resultDescription.textContent = 'Converted to trillions';
                            } else {
                                inputLabel.textContent = 'Enter Trillions';
                                inputUnit.textContent = 'Trillion';
                                inputHelp.textContent = 'Enter the number of trillions to convert';
                                resultTitle.textContent = 'Billions';
                                resultDescription.textContent = 'Converted to billions';
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const mode = getMode();
                            const system = getSystem();
                            const precision = getPrecision();

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                let billions, trillions, millions, quadrillions;

                                if (mode === 'billion-to-trillion') {
                                    billions = inputVal;
                                    if (system === 'short') {
                                        trillions = billions / 1000;
                                        millions = billions * 1000;
                                        quadrillions = billions / 1000000;
                                    } else {
                                        // Long scale: billion = 10^12, trillion = 10^18
                                        trillions = billions / 1000000;
                                        millions = billions / 1000000;
                                        quadrillions = billions / 1000000000000;
                                    }
                                    output.textContent = formatNumber(trillions, precision);
                                } else {
                                    trillions = inputVal;
                                    if (system === 'short') {
                                        billions = trillions * 1000;
                                        millions = billions * 1000;
                                        quadrillions = trillions / 1000;
                                    } else {
                                        billions = trillions * 1000000;
                                        millions = billions / 1000000;
                                        quadrillions = trillions / 1000000;
                                    }
                                    output.textContent = formatNumber(billions, precision);
                                }

                                // Update all displays
                                billionDisplay.textContent = formatNumber(billions, precision);
                                trillionDisplay.textContent = formatNumber(trillions, precision);
                                millionDisplay.textContent = formatNumber(millions, precision);
                                quadrillionDisplay.textContent = formatNumber(quadrillions, precision);
                                
                                // Scientific notation
                                const baseValue = mode === 'billion-to-trillion' ? billions * 1e9 : trillions * 1e12;
                                scientificDisplay.textContent = baseValue.toExponential(3);
                                
                                // Number information
                                const totalValue = baseValue;
                                digitCount.textContent = totalValue.toString().replace(/[^0-9]/g, '').length;
                                zeroCount.textContent = Math.floor(Math.log10(totalValue));

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            billionDisplay.textContent = '--';
                            trillionDisplay.textContent = '--';
                            millionDisplay.textContent = '--';
                            quadrillionDisplay.textContent = '--';
                            scientificDisplay.textContent = '--';
                            digitCount.textContent = '--';
                            zeroCount.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
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

                        systemRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
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

                        // Quick value buttons
                        const quickValues = document.querySelectorAll('.quick-value');
                        quickValues.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                quickValues.forEach(btn => btn.classList.remove('bg-yellow-100', 'text-yellow-700'));
                                quickValues.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-yellow-100', 'text-yellow-700');
                            });
                        });

                        // Initialize
                        updateInterface();
                        inputValue.focus();
                        convert();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                const currentMode = getMode();
                                const newMode = currentMode === 'billion-to-trillion' ? 'trillion-to-billion' : 'billion-to-trillion';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
