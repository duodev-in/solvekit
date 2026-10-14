<x-tool-page-layout
    title="Million to Thousand Converter - SolveKit"
    description="Professional million to thousand converter for financial calculations. Convert between millions, thousands and smaller number denominations with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Million to Thousand</h1>
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
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer bg-teal-50 border-teal-300">
                                                                                        <input type="radio" name="mode" value="million-to-thousand" class="text-teal-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Million → Thousand</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="thousand-to-million" class="text-teal-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Thousand → Million</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    Enter Millions
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
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">Million</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHelp">Enter the number of millions to convert</p>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <select id="category">
                                                                                    <option value="general" selected>General Numbers</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <input type="radio" name="format" value="detailed" checked>
                                                                                <input type="radio" name="format" value="simple">
                                                                                <input type="radio" name="precision" value="0">
                                                                                <input type="radio" name="precision" value="2" checked>
                                                                                <input type="radio" name="precision" value="3">
                                                                                <input type="radio" name="precision" value="auto">
                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-teal-100 hover:bg-teal-200 text-teal-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl border-l-4 border-teal-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Thousands</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted value</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-teal-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-teal-600 hover:text-teal-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Scale Hierarchy Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Millions -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Millions</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="millionDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁶</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Thousands -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Thousands</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="thousandDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10³</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Complete Scale Breakdown -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Hundreds -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Hundreds</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="hundredDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10²</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Tens -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Tens</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="tenDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10¹</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Units -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Units</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="unitDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁰</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Higher Scale Context -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Billions -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Billions</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="billionDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁹</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Scientific Notation -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Scientific</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="scientificDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Exponential</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const category = document.getElementById('category');
                        const modeRadios = document.getElementsByName('mode');
                        const formatRadios = document.getElementsByName('format');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const inputHelp = document.getElementById('inputHelp');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const millionDisplay = document.getElementById('millionDisplay');
                        const thousandDisplay = document.getElementById('thousandDisplay');
                        const hundredDisplay = document.getElementById('hundredDisplay');
                        const tenDisplay = document.getElementById('tenDisplay');
                        const unitDisplay = document.getElementById('unitDisplay');
                        const billionDisplay = document.getElementById('billionDisplay');
                        const scientificDisplay = document.getElementById('scientificDisplay');
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

                            if (mode === 'million-to-thousand') {
                                inputLabel.textContent = 'Enter Millions';
                                inputUnit.textContent = 'Million';
                                inputHelp.textContent = 'Enter the number of millions to convert';
                                resultTitle.textContent = 'Thousands';
                                resultDescription.textContent = 'Converted to thousands';
                            } else {
                                inputLabel.textContent = 'Enter Thousands';
                                inputUnit.textContent = 'Thousand';
                                inputHelp.textContent = 'Enter the number of thousands to convert';
                                resultTitle.textContent = 'Millions';
                                resultDescription.textContent = 'Converted to millions';
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const mode = getMode();
                            const precision = getPrecision();

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                let millions, thousands, hundreds, tens, units, billions;

                                if (mode === 'million-to-thousand') {
                                    millions = inputVal;
                                    thousands = millions * 1000;
                                    hundreds = thousands * 10;
                                    tens = hundreds * 10;
                                    units = tens * 10;
                                    billions = millions / 1000;
                                    
                                    output.textContent = formatNumber(thousands, precision);
                                } else {
                                    thousands = inputVal;
                                    millions = thousands / 1000;
                                    hundreds = thousands * 10;
                                    tens = hundreds * 10;
                                    units = tens * 10;
                                    billions = millions / 1000;
                                    
                                    output.textContent = formatNumber(millions, precision);
                                }

                                // Update all displays
                                millionDisplay.textContent = formatNumber(millions, precision);
                                thousandDisplay.textContent = formatNumber(thousands, precision);
                                hundredDisplay.textContent = formatNumber(hundreds, precision);
                                tenDisplay.textContent = formatNumber(tens, precision);
                                unitDisplay.textContent = formatNumber(units, precision);
                                billionDisplay.textContent = formatNumber(billions, precision);
                                
                                // Scientific notation
                                const baseValue = millions * 1e6;
                                scientificDisplay.textContent = baseValue.toExponential(3);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            millionDisplay.textContent = '--';
                            thousandDisplay.textContent = '--';
                            hundredDisplay.textContent = '--';
                            tenDisplay.textContent = '--';
                            unitDisplay.textContent = '--';
                            billionDisplay.textContent = '--';
                            scientificDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            category.value = 'general';
                            clearOutputs();
                            updateInterface();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        category.addEventListener('change', () => {
                            updateInterface();
                            convert();
                        });
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        formatRadios.forEach(radio => {
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

                        // Financial value buttons
                        const financialValues = document.querySelectorAll('.financial-value');
                        financialValues.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const context = this.getAttribute('data-context');
                                
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                financialValues.forEach(btn => btn.classList.remove('bg-teal-100', 'text-teal-700'));
                                financialValues.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-teal-100', 'text-teal-700');
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
                                const newMode = currentMode === 'million-to-thousand' ? 'thousand-to-million' : 'million-to-thousand';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
