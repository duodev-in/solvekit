<x-tool-page-layout
    title="Crore to Million Converter - SolveKit"
    description="Professional crore to million converter for international business. Convert between Indian crores and Western millions with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Crore to Million</h1>
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
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-green-300 transition-colors cursor-pointer bg-green-50 border-green-300">
                                                                                        <input type="radio" name="mode" value="crore-to-million" class="text-green-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Crore → Million</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-green-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="million-to-crore" class="text-green-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Million → Crore</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    Enter Crores
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
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">Crore</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHelp">Enter the number of crores to convert to millions</p>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <select id="currency">
                                                                                    <option value="none" selected>No Currency</option>
                                                                                </select>
                                                                                <input type="radio" name="display" value="both" checked>
                                                                                <input type="radio" name="display" value="target">
                                                                                <input type="radio" name="precision" value="1">
                                                                                <input type="radio" name="precision" value="2" checked>
                                                                                <input type="radio" name="precision" value="4">
                                                                                <input type="radio" name="precision" value="auto">
                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Millions</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted value</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-green-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-green-600 hover:text-green-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <span id="croreDisplay">--</span>
                                                                                <span id="millionDisplay">--</span>
                                                                            </div>

                                                                            <!-- Complete Denominations -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Lakhs -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Lakhs</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="lakhDisplay">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Thousands -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Thousands</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="thousandDisplay">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Billions -->
                                                                                <div class="p-4 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Billions</h4>
                                                                                        <div class="text-lg font-bold text-red-600 font-mono" id="billionDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Conversion Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Cross-System Reference</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1 Crore = 10 Million</div>
                                                        <div>• 1 Million = 0.1 Crore = 10 Lakh</div>
                                                        <div>• 1 Crore = 100 Lakh = 10,000 Thousand</div>
                                                        <div>• 1 Billion = 100 Crore = 1,000 Million</div>
                                                        <div>• Indian: 1,00,00,000 = Western: 10,000,000</div>
                                                        <div>• Used in: India ↔ US/Europe/Global markets</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const currency = document.getElementById('currency');
                        const modeRadios = document.getElementsByName('mode');
                        const displayRadios = document.getElementsByName('display');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const inputHelp = document.getElementById('inputHelp');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const croreDisplay = document.getElementById('croreDisplay');
                        const millionDisplay = document.getElementById('millionDisplay');
                        const lakhDisplay = document.getElementById('lakhDisplay');
                        const thousandDisplay = document.getElementById('thousandDisplay');
                        const billionDisplay = document.getElementById('billionDisplay');
                        const copyResult = document.getElementById('copyResult');

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
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

                            if (mode === 'crore-to-million') {
                                inputLabel.textContent = 'Enter Crores';
                                inputUnit.textContent = 'Crore';
                                inputHelp.textContent = 'Enter the number of crores to convert to millions';
                                resultTitle.textContent = 'Millions';
                                resultDescription.textContent = 'Converted to millions';
                            } else {
                                inputLabel.textContent = 'Enter Millions';
                                inputUnit.textContent = 'Million';
                                inputHelp.textContent = 'Enter the number of millions to convert to crores';
                                resultTitle.textContent = 'Crores';
                                resultDescription.textContent = 'Converted to crores';
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const mode = getMode();
                            const precision = getPrecision();

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                let crores, millions, lakhs, thousands, billions;

                                if (mode === 'crore-to-million') {
                                    crores = inputVal;
                                    millions = crores * 10;
                                    lakhs = crores * 100;
                                    thousands = crores * 10000;
                                    billions = crores / 100;
                                    
                                    output.textContent = formatNumber(millions, precision);
                                } else {
                                    millions = inputVal;
                                    crores = millions / 10;
                                    lakhs = millions * 10;
                                    thousands = millions * 1000;
                                    billions = millions / 1000;
                                    
                                    output.textContent = formatNumber(crores, precision);
                                }

                                // Update all displays
                                croreDisplay.textContent = formatNumber(crores, precision);
                                millionDisplay.textContent = formatNumber(millions, precision);
                                lakhDisplay.textContent = formatNumber(lakhs, precision);
                                thousandDisplay.textContent = formatNumber(thousands, precision);
                                billionDisplay.textContent = formatNumber(billions, precision);
                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            croreDisplay.textContent = '--';
                            millionDisplay.textContent = '--';
                            lakhDisplay.textContent = '--';
                            thousandDisplay.textContent = '--';
                            billionDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            currency.value = 'none';
                            clearOutputs();
                            updateInterface();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        currency.addEventListener('change', () => {
                            updateInterface();
                            convert();
                        });
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        displayRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
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

                        // Business example buttons
                        const businessExamples = document.querySelectorAll('.business-example');
                        businessExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                businessExamples.forEach(btn => btn.classList.remove('bg-green-100', 'text-green-700'));
                                businessExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-green-100', 'text-green-700');
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
                                const newMode = currentMode === 'crore-to-million' ? 'million-to-crore' : 'crore-to-million';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
