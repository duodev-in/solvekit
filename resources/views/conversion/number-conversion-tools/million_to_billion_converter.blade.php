<x-tool-page-layout
    title="Million to Billion Converter - SolveKit"
    description="Professional million to billion converter for finance and business calculations. Convert between millions, billions and other large Western denominations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Million to Billion</h1>
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
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer bg-purple-50 border-purple-300">
                                                                                        <input type="radio" name="mode" value="million-to-billion" class="text-purple-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Million → Billion</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="billion-to-million" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Billion → Million</span>
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

                                                                            <!-- Number System -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Number System
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="system" value="short" class="text-purple-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Short Scale (US)</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="system" value="long" class="text-purple-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Long Scale (EU)</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <select id="context">
                                                                                    <option value="general" selected>General Numbers</option>
                                                                                </select>
                                                                                <input type="radio" name="precision" value="1">
                                                                                <input type="radio" name="precision" value="3" checked>
                                                                                <input type="radio" name="precision" value="6">
                                                                                <input type="radio" name="precision" value="auto">
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
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Billions</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted value</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-purple-600 hover:text-purple-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Primary Scale Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Millions -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Millions</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="millionDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁶</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Billions -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Billions</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="billionDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁹</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Extended Scale Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Thousands -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Thousands</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="thousandDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10³</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Trillions -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Trillions</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="trillionDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10¹²</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Scientific Notation -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Scientific</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="scientificDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Exponential</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Indian System Equivalents -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Crores -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Crores (Indian)</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="croreDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁷</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Lakhs -->
                                                                                <div class="p-4 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Lakhs (Indian)</h4>
                                                                                        <div class="text-lg font-bold text-teal-600 font-mono" id="lakhDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">10⁵</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden" aria-hidden="true">
                                                                                <span id="contextDisplay">General</span>
                                                                                <span id="scaleLevel">--</span>
                                                                                <span id="categoryLevel">--</span>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Western Number Scale Reference</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1,000 = One Thousand (10³)</div>
                                                        <div>• 1,000,000 = One Million (10⁶)</div>
                                                        <div>• 1,000,000,000 = One Billion (10⁹)</div>
                                                        <div>• 1,000,000,000,000 = One Trillion (10¹²)</div>
                                                        <div>• 1 Million = 1,000 Thousands</div>
                                                        <div>• 1 Billion = 1,000 Millions</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const context = document.getElementById('context');
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
                        const millionDisplay = document.getElementById('millionDisplay');
                        const billionDisplay = document.getElementById('billionDisplay');
                        const thousandDisplay = document.getElementById('thousandDisplay');
                        const trillionDisplay = document.getElementById('trillionDisplay');
                        const scientificDisplay = document.getElementById('scientificDisplay');
                        const croreDisplay = document.getElementById('croreDisplay');
                        const lakhDisplay = document.getElementById('lakhDisplay');
                        const contextDisplay = document.getElementById('contextDisplay');
                        const scaleLevel = document.getElementById('scaleLevel');
                        const categoryLevel = document.getElementById('categoryLevel');
                        const copyResult = document.getElementById('copyResult');

                        // Context descriptions
                        const contextDescriptions = {
                            'general': 'General Numbers',
                            'revenue': 'Company Revenue',
                            'valuation': 'Business Valuation',
                            'market-cap': 'Market Capitalization',
                            'gdp': 'GDP/Economic Data',
                            'budget': 'Government Budget',
                            'investment': 'Investment Fund'
                        };

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

                        function getCompanySize(millions) {
                            const billions = millions / 1000;
                            if (billions >= 200) return 'Mega Cap';
                            if (billions >= 10) return 'Large Cap';
                            if (billions >= 2) return 'Mid Cap';
                            if (millions >= 300) return 'Small Cap';
                            if (millions >= 50) return 'Micro Cap';
                            return 'Nano Cap';
                        }

                        function getScaleLevel(num) {
                            if (num >= 1e12) return 'Trillion Scale';
                            if (num >= 1e9) return 'Billion Scale';
                            if (num >= 1e6) return 'Million Scale';
                            if (num >= 1e3) return 'Thousand Scale';
                            return 'Unit Scale';
                        }

                        function updateInterface() {
                            const mode = getMode();
                            const selectedContext = context.value;
                            
                            contextDisplay.textContent = contextDescriptions[selectedContext] || 'General';
                            
                            if (mode === 'million-to-billion') {
                                inputLabel.textContent = 'Enter Millions';
                                inputUnit.textContent = 'Million';
                                inputHelp.textContent = 'Enter the number of millions to convert';
                                resultTitle.textContent = 'Billions';
                                resultDescription.textContent = 'Converted to billions';
                            } else {
                                inputLabel.textContent = 'Enter Billions';
                                inputUnit.textContent = 'Billion';
                                inputHelp.textContent = 'Enter the number of billions to convert';
                                resultTitle.textContent = 'Millions';
                                resultDescription.textContent = 'Converted to millions';
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const mode = getMode();
                            const system = getSystem();
                            const precision = getPrecision();

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                let millions, billions, thousands, trillions, crores, lakhs;

                                if (mode === 'million-to-billion') {
                                    millions = inputVal;
                                    if (system === 'short') {
                                        billions = millions / 1000;
                                        thousands = millions * 1000;
                                        trillions = billions / 1000;
                                    } else {
                                        // Long scale: billion = 10^12
                                        billions = millions / 1000000;
                                        thousands = millions * 1000;
                                        trillions = billions / 1000000;
                                    }
                                    output.textContent = formatNumber(billions, precision);
                                } else {
                                    billions = inputVal;
                                    if (system === 'short') {
                                        millions = billions * 1000;
                                        thousands = millions * 1000;
                                        trillions = billions / 1000;
                                    } else {
                                        millions = billions * 1000000;
                                        thousands = millions * 1000;
                                        trillions = billions / 1000000;
                                    }
                                    output.textContent = formatNumber(millions, precision);
                                }

                                // Indian system equivalents
                                crores = millions / 10;
                                lakhs = millions * 10;

                                // Update all displays
                                millionDisplay.textContent = formatNumber(millions, precision);
                                billionDisplay.textContent = formatNumber(billions, precision);
                                thousandDisplay.textContent = formatNumber(thousands, precision);
                                trillionDisplay.textContent = formatNumber(trillions, precision);
                                croreDisplay.textContent = formatNumber(crores, precision);
                                lakhDisplay.textContent = formatNumber(lakhs, precision);
                                
                                // Scientific notation
                                const baseValue = millions * 1e6;
                                scientificDisplay.textContent = baseValue.toExponential(3);
                                
                                // Analysis
                                scaleLevel.textContent = getScaleLevel(baseValue);
                                
                                // Category based on context
                                const selectedContext = context.value;
                                switch(selectedContext) {
                                    case 'revenue':
                                        categoryLevel.textContent = millions >= 1000 ? 'Fortune 500' : 'Growing Company';
                                        break;
                                    case 'valuation':
                                        categoryLevel.textContent = millions >= 1000 ? 'Unicorn+' : 'Growth Stage';
                                        break;
                                    case 'market-cap':
                                        categoryLevel.textContent = getCompanySize(millions);
                                        break;
                                    default:
                                        categoryLevel.textContent = getScaleLevel(baseValue);
                                }

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            millionDisplay.textContent = '--';
                            billionDisplay.textContent = '--';
                            thousandDisplay.textContent = '--';
                            trillionDisplay.textContent = '--';
                            scientificDisplay.textContent = '--';
                            croreDisplay.textContent = '--';
                            lakhDisplay.textContent = '--';
                            scaleLevel.textContent = '--';
                            categoryLevel.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            context.value = 'general';
                            clearOutputs();
                            updateInterface();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        context.addEventListener('change', () => {
                            updateInterface();
                            convert();
                        });
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        systemRadios.forEach(radio => {
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

                        // Financial example buttons
                        const financialExamples = document.querySelectorAll('.financial-example');
                        financialExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const contextValue = this.getAttribute('data-context');
                                
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                financialExamples.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                financialExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-purple-100', 'text-purple-700');
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
                                const newMode = currentMode === 'million-to-billion' ? 'billion-to-million' : 'million-to-billion';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
